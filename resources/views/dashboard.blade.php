@extends('layouts.app')

@section('title', '會員儀表板')

@section('content')
    <!-- Ocean-themed dashboard header with bubbles instead of wave -->
    <div class="dashboard-header mb-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-5 fw-bold text-white mb-0">歡迎回來，{{ Auth::user()->name }}！</h1>
                    <p class="text-light mb-0">{{ now()->format('Y年m月d日') }}</p>
                </div>
                {{-- <div class="col-md-6 d-none d-md-block">
                    <div class="dashboard-illustration">
                        <img src="{{ asset('images/diver-silhouette.svg') }}" alt="Diver" class="diver-silhouette">
                    </div>
                </div> --}}
            </div>
        </div>
        <!-- Bubbles instead of wave -->
        <div class="bubble-container">
            <div class="bubble bubble-1"></div>
            <div class="bubble bubble-2"></div>
            <div class="bubble bubble-3"></div>
            <div class="bubble bubble-4"></div>
            <div class="bubble bubble-5"></div>
            <div class="bubble bubble-6"></div>
        </div>
    </div>

    <div class="container">
        <!-- Quick Links Section -->
        <div class="quick-links-section mb-5">
            <div class="section-title-container mb-3">
                <h2 class="section-title">快速連結</h2>
                <div class="section-title-decoration">
                    <span class="section-line"></span>
                    <div class="section-icon">
                        <i class="bi bi-grid"></i>
                    </div>
                    <span class="section-line"></span>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <a href="{{ route('profile.edit') }}" class="quick-link-card">
                        <div class="quick-link-icon-container">
                            <div class="quick-link-icon">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <div class="quick-link-icon-ring"></div>
                        </div>
                        <div class="quick-link-text">個人資料</div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('member.activities') }}" class="quick-link-card">
                        <div class="quick-link-icon-container">
                            <div class="quick-link-icon">
                                <i class="bi bi-calendar2-week"></i>
                            </div>
                            <div class="quick-link-icon-ring"></div>
                        </div>
                        <div class="quick-link-text">我的活動</div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('announcements.index') }}" class="quick-link-card">
                        <div class="quick-link-icon-container">
                            <div class="quick-link-icon">
                                <i class="bi bi-megaphone"></i>
                            </div>
                            <div class="quick-link-icon-ring"></div>
                        </div>
                        <div class="quick-link-text">最新公告</div>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('member.comments') }}" class="quick-link-card">
                        <div class="quick-link-icon-container">
                            <div class="quick-link-icon">
                                <i class="bi bi-chat-dots"></i>
                            </div>
                            <div class="quick-link-icon-ring"></div>
                        </div>
                        <div class="quick-link-text">我的評論</div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats cards with ocean-themed design -->
        <div class="row g-4 stats-container">
            <div class="col-md-4 col-lg">
                <div class="stat-card stat-primary">
                    <div class="stat-icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-value">{{ Auth::user()->registrations()->count() }}</h3>
                        <p class="stat-label">我的活動報名</p>
                    </div>
                    <div class="stat-water"></div>
                </div>
            </div>

            <div class="col-md-4 col-lg">
                <div class="stat-card stat-success">
                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-value">
                            {{ Auth::user()->registrations()->where('status', 'approved')->count() }}
                        </h3>
                        <p class="stat-label">已確認活動</p>
                    </div>
                    <div class="stat-water"></div>
                </div>
            </div>

            <div class="col-md-4 col-lg">
                <div class="stat-card stat-warning">
                    <div class="stat-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-value">
                            {{ Auth::user()->registrations()->where('status', 'pending')->count() }}
                        </h3>
                        <p class="stat-label">待審核活動</p>
                    </div>
                    <div class="stat-water"></div>
                </div>
            </div>

            <div class="col-md-4 col-lg">
                <div class="stat-card stat-info">
                    <div class="stat-icon">
                        <i class="bi bi-megaphone"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-value">
                            {{ App\Models\Announcement::where('is_published', true)->count() }}
                        </h3>
                        <p class="stat-label">最新公告</p>
                    </div>
                    <div class="stat-water"></div>
                </div>
            </div>

            <div class="col-md-4 col-lg">
                <div class="stat-card stat-secondary">
                    <div class="stat-icon">
                        <i class="bi bi-chat-dots"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-value">{{ Auth::user()->comments()->count() }}</h3>
                        <p class="stat-label">我的評論</p>
                    </div>
                    <div class="stat-water"></div>
                </div>
            </div>
        </div>

        <!-- Content cards with ocean styling -->
        <div class="row g-4 mt-2">
            <div class="col-lg-6">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-calendar-check me-2"></i>
                            我的最近報名
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            $recentRegistrations = Auth::user()
                                ->registrations()
                                ->with('activity')
                                ->latest()
                                ->take(5)
                                ->get();
                        @endphp

                        @if ($recentRegistrations->count() > 0)
                            <div class="list-group registrations-list">
                                @foreach ($recentRegistrations as $registration)
                                    <div class="list-group-item registration-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="registration-info">
                                                <h6 class="mb-1">{{ $registration->activity->title }}</h6>
                                                <div class="text-muted activity-meta">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    {{ $registration->activity->start_date->format('Y/m/d H:i') }}
                                                    <i class="bi bi-geo-alt ms-2 me-1"></i>
                                                    {{ $registration->activity->location }}
                                                </div>
                                            </div>
                                            <span class="status-badge status-{{ $registration->status }}">
                                                {{ $registration->status == 'approved' ? '已確認' : ($registration->status == 'pending' ? '待審核' : '已拒絕') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('member.activities') }}" class="btn btn-ocean">
                                    查看全部 <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="bi bi-calendar-x"></i>
                                </div>
                                <p>您尚未報名任何活動</p>
                                <a href="{{ route('activities.index') }}" class="btn btn-ocean">
                                    瀏覽活動 <i class="bi bi-search ms-1"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-megaphone-fill me-2"></i>
                            最新公告
                        </h5>
                    </div>
                    <div class="card-body">
                        @php
                            $latestAnnouncements = App\Models\Announcement::where('is_published', true)
                                ->orderBy('published_at', 'desc')
                                ->take(5)
                                ->get();
                        @endphp

                        @if ($latestAnnouncements->count() > 0)
                            <div class="list-group announcement-list">
                                @foreach ($latestAnnouncements as $announcement)
                                    <a href="{{ route('announcements.show', $announcement) }}"
                                        class="list-group-item list-group-item-action announcement-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">
                                                    {{ $announcement->title }}
                                                    @if ($announcement->is_pinned)
                                                        <span class="pin-badge">
                                                            <i class="bi bi-pin-angle-fill"></i>
                                                        </span>
                                                    @endif
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    {{ $announcement->published_at->format('Y/m/d') }}
                                                </small>
                                            </div>
                                            <i class="bi bi-chevron-right announcement-arrow"></i>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('announcements.index') }}" class="btn btn-ocean">
                                    查看全部 <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="bi bi-megaphone"></i>
                                </div>
                                <p>目前沒有公告</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming activities suggestion -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-compass me-2"></i>
                            為您推薦的活動
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4 suggested-activities">
                            @foreach (App\Models\Activity::where('start_date', '>', now())->orderBy('start_date', 'asc')->take(3)->get() as $activity)
                                <div class="col-md-4">
                                    <div class="activity-card">
                                        <div class="activity-date">
                                            <span class="month">{{ $activity->start_date->format('m') }}月</span>
                                            <span class="day">{{ $activity->start_date->format('d') }}</span>
                                        </div>
                                        <h6 class="activity-title">{{ $activity->title }}</h6>
                                        <div class="activity-details">
                                            <p>
                                                <i class="bi bi-geo-alt-fill"></i>
                                                {{ $activity->location }}
                                            </p>
                                            <a href="{{ route('activities.show', $activity) }}"
                                                class="btn btn-sm btn-outline-ocean">
                                                查看詳情
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Dashboard Header with Bubbles instead of Wave */
        .dashboard-header {
            background: linear-gradient(135deg, #004766, #006994, #0077be, #1e90ff);
            padding: 3rem 0;
            position: relative;
            margin-top: -1.5rem;
            overflow: hidden;
            border-radius: 0 0 20px 20px;
        }

        .dashboard-illustration {
            position: relative;
            height: 100%;
            text-align: right;
        }

        .diver-silhouette {
            height: 120px;
            opacity: 0.7;
            position: relative;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        /* Bubble animation replacing wave */
        .bubble-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
            pointer-events: none;
        }

        .bubble {
            position: absolute;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            animation: float-bubble 8s ease-in-out infinite;
        }

        .bubble-1 {
            width: 40px;
            height: 40px;
            left: 10%;
            bottom: 5%;
            animation-delay: 0s;
            animation-duration: 6s;
        }

        .bubble-2 {
            width: 25px;
            height: 25px;
            left: 25%;
            bottom: 10%;
            animation-delay: 1s;
            animation-duration: 7s;
        }

        .bubble-3 {
            width: 50px;
            height: 50px;
            right: 30%;
            bottom: 7%;
            animation-delay: 2s;
            animation-duration: 8s;
        }

        .bubble-4 {
            width: 35px;
            height: 35px;
            right: 10%;
            bottom: 15%;
            animation-delay: 3s;
            animation-duration: 5s;
        }

        .bubble-5 {
            width: 30px;
            height: 30px;
            left: 40%;
            bottom: 5%;
            animation-delay: 2.5s;
            animation-duration: 6.5s;
        }

        .bubble-6 {
            width: 20px;
            height: 20px;
            right: 15%;
            bottom: 10%;
            animation-delay: 3.5s;
            animation-duration: 4.5s;
        }

        @keyframes float-bubble {
            0% {
                transform: translateY(0);
                opacity: 0.2;
            }

            50% {
                transform: translateY(-120px);
                opacity: 0.8;
            }

            100% {
                transform: translateY(-200px);
                opacity: 0;
            }
        }

        /* Enhanced Quick Links Section */
        .quick-links-section {
            margin-top: 15px;
            margin-bottom: 35px;
        }

        /* Section Title Styling */
        .section-title-container {
            text-align: center;
            position: relative;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #006994;
            margin-bottom: 0.5rem;
            position: relative;
            display: inline-block;
        }

        .section-title-decoration {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0.25rem 0 1.25rem;
        }

        .section-line {
            height: 2px;
            width: 70px;
            background: linear-gradient(to var(--direction, right), #0077be, rgba(0, 119, 190, 0.2));
            display: inline-block;
        }

        .section-line:first-child {
            --direction: right;
        }

        .section-line:last-child {
            --direction: left;
        }

        .section-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0077be, #1e90ff);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            color: white;
            font-size: 14px;
            box-shadow: 0 3px 5px rgba(0, 119, 190, 0.3);
        }

        /* Enhanced Quick Link Cards */
        .quick-link-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            text-decoration: none;
            color: #333;
            height: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .quick-link-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 119, 190, 0.05), rgba(0, 119, 190, 0));
            z-index: -1;
        }

        .quick-link-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 12px 25px rgba(0, 119, 190, 0.15);
            color: #0077be;
        }

        .quick-link-icon-container {
            position: relative;
            width: 70px;
            height: 70px;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quick-link-icon {
            font-size: 2rem;
            color: #0077be;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: rgba(0, 119, 190, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            position: relative;
            transition: all 0.3s ease;
        }

        .quick-link-icon-ring {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid rgba(0, 119, 190, 0.15);
            z-index: 1;
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.3s ease;
        }

        .quick-link-card:hover .quick-link-icon {
            background-color: rgba(0, 119, 190, 0.15);
            transform: scale(1.05);
            color: #0067a5;
        }

        .quick-link-card:hover .quick-link-icon-ring {
            opacity: 1;
            transform: scale(1);
            animation: pulse 1.5s infinite;
        }

        .quick-link-text {
            font-weight: 600;
            font-size: 1.05rem;
            transition: all 0.3s ease;
        }

        .quick-link-card:hover .quick-link-text {
            transform: translateY(2px);
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.8;
            }

            70% {
                transform: scale(1.1);
                opacity: 0.3;
            }

            100% {
                transform: scale(1);
                opacity: 0.8;
            }
        }

        @media (max-width: 767.98px) {
            .section-title {
                font-size: 1.5rem;
            }

            .section-line {
                width: 50px;
            }

            .quick-link-icon {
                font-size: 1.75rem;
                width: 50px;
                height: 50px;
            }

            .quick-link-text {
                font-size: 0.95rem;
            }
        }

        .quick-link-text {
            font-weight: 600;
            font-size: 1rem;
        }

        /* Ocean-themed Stat Cards */
        .stats-container {
            margin-top: 0;
        }

        .stat-card {
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            height: 140px;
            display: flex;
            align-items: center;
            border: none;
            background: #fff;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            z-index: 10;
        }

        .stat-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 1rem;
            z-index: 2;
            color: white;
        }

        .stat-content {
            flex-grow: 1;
            z-index: 2;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.9rem;
            margin-bottom: 0;
            color: #333;
            font-weight: 500;
        }

        .stat-water {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 35%;
            opacity: 0.15;
            z-index: 1;
        }

        .stat-primary .stat-icon {
            background: #0077be;
        }

        .stat-primary .stat-value {
            color: #0077be;
        }

        .stat-primary .stat-water {
            background: #0077be;
        }

        .stat-success .stat-icon {
            background: #198754;
        }

        .stat-success .stat-value {
            color: #198754;
        }

        .stat-success .stat-water {
            background: #198754;
        }

        .stat-warning .stat-icon {
            background: #ffc107;
        }

        .stat-warning .stat-value {
            color: #ffc107;
        }

        .stat-warning .stat-water {
            background: #ffc107;
        }

        .stat-info .stat-icon {
            background: #0dcaf0;
        }

        .stat-info .stat-value {
            color: #0dcaf0;
        }

        .stat-info .stat-water {
            background: #0dcaf0;
        }

        .stat-secondary .stat-icon {
            background: #6c757d;
        }

        .stat-secondary .stat-value {
            color: #6c757d;
        }

        .stat-secondary .stat-water {
            background: #6c757d;
        }

        /* Content Cards */
        .content-card {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            background-color: #fff;
            border: none;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .content-card:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .content-card-header {
            padding: 1.25rem 1.5rem;
            background: linear-gradient(to right, rgba(0, 119, 190, 0.1), rgba(0, 119, 190, 0.02));
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .content-card-header h5 {
            color: #0077be;
            font-weight: 600;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Registration List */
        .registrations-list,
        .announcement-list {
            box-shadow: none;
        }

        .registration-item,
        .announcement-item {
            border: none;
            border-radius: 10px;
            margin-bottom: 0.75rem;
            transition: all 0.2s ease;
            padding: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .registration-item:hover,
        .announcement-item:hover {
            background-color: rgba(0, 119, 190, 0.03);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .registration-info {
            flex-grow: 1;
        }

        .activity-meta {
            font-size: 0.85rem;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
            color: white;
        }

        .status-approved {
            background-color: #198754;
        }

        .status-pending {
            background-color: #ffc107;
            color: #212529;
        }

        .status-rejected {
            background-color: #dc3545;
        }

        .pin-badge {
            font-size: 0.75rem;
            color: #dc3545;
            margin-left: 0.3rem;
        }

        .announcement-arrow {
            color: #0077be;
            font-size: 0.9rem;
            transition: transform 0.2s ease;
        }

        .announcement-item:hover .announcement-arrow {
            transform: translateX(3px);
        }

        /* Empty states */
        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
        }

        .empty-icon {
            font-size: 3rem;
            color: rgba(0, 119, 190, 0.2);
            margin-bottom: 1rem;
        }

        /* Ocean-style buttons */
        .btn-ocean {
            background: linear-gradient(135deg, #0077be, #1e90ff);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-ocean:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 119, 190, 0.4);
            color: white;
        }

        .btn-ocean:active {
            transform: translateY(-1px);
        }

        .btn-outline-ocean {
            color: #0077be;
            border: 1px solid #0077be;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-outline-ocean:hover {
            background-color: #0077be;
            color: white;
            transform: translateY(-2px);
        }

        /* Suggested activities cards */
        .activity-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 1.25rem;
            background: linear-gradient(to bottom, #fff, #f8fcff);
            border: 1px solid rgba(0, 119, 190, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
        }

        .activity-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 119, 190, 0.1);
        }

        .activity-date {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: rgba(0, 119, 190, 0.9);
            border-radius: 8px;
            padding: 0.3rem 0.5rem;
            color: white;
            text-align: center;
            line-height: 1.1;
        }

        .activity-date .month {
            display: block;
            font-size: 0.7rem;
        }

        .activity-date .day {
            display: block;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .activity-title {
            margin-top: 0.5rem;
            margin-bottom: 1.25rem;
            padding-right: 60px;
            font-weight: 600;
            color: #006994;
        }

        .activity-details p {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
        }

        /* Ripple effect for buttons */
        .btn-ocean {
            position: relative;
            overflow: hidden;
        }

        .ripple {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.4);
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        }

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .dashboard-header {
                padding: 2rem 0;
            }

            .stats-container {
                margin-top: 0;
            }

            .stat-card {
                height: 120px;
                margin-bottom: 1rem;
            }

            .stat-icon {
                font-size: 24px;
                width: 50px;
                height: 50px;
            }

            .stat-value {
                font-size: 1.75rem;
            }

            .quick-link-icon {
                font-size: 1.75rem;
            }

            .quick-link-text {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 575.98px) {
            .dashboard-header h1 {
                font-size: 1.75rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add wave ripple effect to ocean buttons
            const oceanButtons = document.querySelectorAll('.btn-ocean');

            oceanButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    const circle = document.createElement('span');
                    const diameter = Math.max(button.clientWidth, button.clientHeight);
                    const radius = diameter / 2;

                    circle.style.width = circle.style.height = `${diameter}px`;
                    circle.style.left = `${e.clientX - button.offsetLeft - radius}px`;
                    circle.style.top = `${e.clientY - button.offsetTop - radius}px`;
                    circle.classList.add('ripple');

                    const ripple = button.getElementsByClassName('ripple')[0];

                    if (ripple) {
                        ripple.remove();
                    }

                    button.appendChild(circle);
                });
            });
        });
    </script>
@endpush
