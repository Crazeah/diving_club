<?php

// app/Http/Controllers/ActivityController.php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use App\Models\ActivityCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Notifications\RegistrationCancelled;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::query()->where('is_published', true);

        if ($request->has('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $activities = $query->orderBy('start_date', 'asc')->paginate(9);
        $categories = ActivityCategory::all();

        return view('activities.index', compact('activities', 'categories'));
    }

    public function show(Activity $activity)
    {
        if (!$activity->is_published) {
            abort(404);
        }
        $activity->load(['comments' => function ($query) {
            $query->approved()
                ->whereNull('parent_id')
                ->latest()
                ->with(['user', 'replies' => function ($q) {
                    $q->approved()->with('user');
                }]);
        }]);

        return view('activities.show', compact('activity'));
    }

    // app/Http/Controllers/ActivityController.php
    public function register(Activity $activity, Request $request)
    {
        // 檢查是否在報名時間內
        $now = now();
        if (!$now->between($activity->registration_start, $activity->registration_end)) {
            return back()->with('error', '目前不在報名時間內');
        }

        // 檢查是否已報名
        if ($activity->registrations()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', '您已經報名過此活動');
        }

        // 檢查人數是否已滿
        $registrationCount = $activity->registrations()->count();
        if ($activity->max_participants > 0 && $registrationCount >= $activity->max_participants) {
            return back()->with('error', '活動報名人數已滿');
        }

        try {
            // 建立報名紀錄
            $activity->registrations()->create([
                'user_id' => Auth::id(),
                'status' => 'pending',
            ]);

            return back()->with('success', '報名成功');
        } catch (\Exception $e) {
            // 記錄錯誤
            Log::error('活動報名失敗: ' . $e->getMessage());
            return back()->with('error', '報名處理時發生錯誤，請稍後再試');
        }
    }

    public function unregister(Activity $activity, Request $request)
    {
        try {
            // 先獲取報名記錄
            $registration = $activity->registrations()->where('user_id', auth()->id())->first();

            if ($registration) {
                // 保存報名記錄的副本，以便發送通知
                $user = auth()->user();

                // 刪除報名記錄
                $registration->delete();

                // 發送取消報名通知
                try {
                    $user->notify(new RegistrationCancelled($registration));
                } catch (\Exception $e) {
                    // 記錄通知失敗但不中斷流程
                    Log::error('發送取消報名通知失敗: ' . $e->getMessage());
                }

                return back()->with('success', '已取消報名');
            } else {
                return back()->with('error', '您尚未報名此活動');
            }
        } catch (\Exception $e) {
            // 記錄錯誤
            Log::error('取消活動報名失敗: ' . $e->getMessage());
            return back()->with('error', '取消報名處理時發生錯誤，請稍後再試');
        }
    }
}
