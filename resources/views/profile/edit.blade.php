@extends('layouts.app')

@section('title', '個人資料')

@section('content')
    <div class="profile-header">
        <div class="container header-content">
            <h1 class="text-white mb-0">個人資料</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-white-50">儀表板</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">個人資料</li>
                </ol>
            </nav>
        </div>
        <div class="bubble-container">
            <div class="bubble bubble-1"></div>
            <div class="bubble bubble-2"></div>
            <div class="bubble bubble-3"></div>
            <div class="bubble bubble-4"></div>
            <div class="bubble bubble-5"></div>
            <div class="bubble bubble-6"></div>
            <div class="bubble bubble-7"></div>
            <div class="bubble bubble-8"></div>
        </div>
    </div>

    <div class="container py-4">
        <div class="row g-4">
            <!-- 側邊欄 -->
            <div class="col-lg-3">
                <div class="user-profile-sidebar">
                    <div class="profile-card">
                        <div class="profile-header-bg"></div>
                        <div class="profile-avatar-wrapper">
                            <div class="profile-avatar">
                                <i class="bi bi-person-fill"></i>
                                <div class="profile-avatar-bubble profile-avatar-bubble-1"></div>
                                <div class="profile-avatar-bubble profile-avatar-bubble-2"></div>
                                <div class="profile-avatar-bubble profile-avatar-bubble-3"></div>
                            </div>
                        </div>
                        <div class="profile-info">
                            <h5 class="profile-name">{{ $user->name }}</h5>
                            <p class="profile-email">{{ $user->email }}</p>
                            <div class="profile-meta">
                                <div class="profile-meta-item">
                                    <i class="bi bi-award"></i>
                                    <span>{{ $user->diving_experience ? ucfirst($user->diving_experience) : 'No experience yet' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="quick-nav-card mt-4">
                        <h6 class="nav-card-title">
                            <i class="bi bi-lightning-charge-fill"></i>
                            快速連結
                        </h6>
                        <div class="nav-links">
                            <a href="{{ route('dashboard') }}" class="nav-link-item">
                                <div class="nav-link-icon">
                                    <i class="bi bi-house"></i>
                                </div>
                                <span>儀表板</span>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                            <a href="{{ route('member.activities') }}" class="nav-link-item">
                                <div class="nav-link-icon">
                                    <i class="bi bi-calendar"></i>
                                </div>
                                <span>我的活動</span>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                            <a href="{{ route('activities.index') }}" class="nav-link-item">
                                <div class="nav-link-icon">
                                    <i class="bi bi-list"></i>
                                </div>
                                <span>瀏覽活動</span>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 主要內容 -->
            <div class="col-lg-9">
                <!-- 個人資料編輯 -->
                <div class="content-card">
                    <div class="content-card-header">
                        <h5 class="content-card-title">
                            <i class="bi bi-person-lines-fill me-2 text-primary"></i>
                            個人資料
                        </h5>
                        @if (session('status') === 'profile-updated')
                            <div class="success-badge">
                                <i class="bi bi-check-circle me-1"></i> 已更新
                            </div>
                        @endif
                    </div>
                    <div class="content-card-body">
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <form method="post" action="{{ route('profile.update') }}" class="ocean-form">
                            @csrf
                            @method('patch')

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $user->name) }}" required
                                            placeholder="Your name">
                                        <label for="name">姓名 <span class="text-danger">*</span></label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $user->email) }}" required
                                            placeholder="email@example.com">
                                        <label for="email">電子郵件 <span class="text-danger">*</span></label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                            <div class="verification-notice mt-2">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                                <span>您的電子郵件地址尚未驗證。</span>
                                                <button form="send-verification" class="resend-link">
                                                    點擊此處重新發送驗證郵件
                                                </button>
                                            </div>

                                            @if (session('status') === 'verification-link-sent')
                                                <div class="verification-success mt-2">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    <span>新的驗證連結已發送到您的電子郵件地址。</span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 mt-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="phone" name="phone"
                                            value="{{ old('phone', $user->phone ?? '') }}" placeholder="Your phone">
                                        <label for="phone">聯絡電話</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="emergency_contact"
                                            name="emergency_contact"
                                            value="{{ old('emergency_contact', $user->emergency_contact ?? '') }}"
                                            placeholder="Emergency contact">
                                        <label for="emergency_contact">緊急聯絡人</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 mt-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="emergency_phone"
                                            name="emergency_phone"
                                            value="{{ old('emergency_phone', $user->emergency_phone ?? '') }}"
                                            placeholder="Emergency phone">
                                        <label for="emergency_phone">緊急聯絡電話</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" id="birth_date" name="birth_date"
                                            value="{{ old('birth_date', $user->birth_date ?? '') }}"
                                            placeholder="Birth date">
                                        <label for="birth_date">出生日期</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4 mt-1">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="diving_experience" name="diving_experience">
                                            <option value="">請選擇</option>
                                            <option value="none"
                                                {{ old('diving_experience', $user->diving_experience ?? '') == 'none' ? 'selected' : '' }}>
                                                無經驗</option>
                                            <option value="beginner"
                                                {{ old('diving_experience', $user->diving_experience ?? '') == 'beginner' ? 'selected' : '' }}>
                                                初學者</option>
                                            <option value="intermediate"
                                                {{ old('diving_experience', $user->diving_experience ?? '') == 'intermediate' ? 'selected' : '' }}>
                                                中級</option>
                                            <option value="advanced"
                                                {{ old('diving_experience', $user->diving_experience ?? '') == 'advanced' ? 'selected' : '' }}>
                                                進階</option>
                                            <option value="expert"
                                                {{ old('diving_experience', $user->diving_experience ?? '') == 'expert' ? 'selected' : '' }}>
                                                專家</option>
                                        </select>
                                        <label for="diving_experience">潛水經驗</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="diving_certification"
                                            name="diving_certification"
                                            value="{{ old('diving_certification', $user->diving_certification ?? '') }}"
                                            placeholder="Certification">
                                        <label for="diving_certification">潛水證照</label>
                                        <div class="form-hint">例如：PADI OW, AOW, Rescue</div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <div class="form-floating">
                                    <textarea class="form-control" id="medical_conditions" name="medical_conditions" style="height: 100px"
                                        placeholder="Medical conditions">{{ old('medical_conditions', $user->medical_conditions ?? '') }}</textarea>
                                    <label for="medical_conditions">健康狀況/醫療記錄</label>
                                    <div class="form-hint">這些資訊僅供安全考量使用，不會公開顯示。</div>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary btn-ocean">
                                    <i class="bi bi-save me-2"></i>儲存變更
                                    <span class="btn-wave"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- 修改密碼 -->
                <div class="content-card mt-4">
                    <div class="content-card-header">
                        <h5 class="content-card-title">
                            <i class="bi bi-shield-lock-fill me-2 text-primary"></i>
                            修改密碼
                        </h5>
                    </div>
                    <div class="content-card-body">
                        <div class="notice-box">
                            <div class="notice-icon">
                                <i class="bi bi-info-circle-fill"></i>
                            </div>
                            <div class="notice-content">
                                <p>請至 <a href="https://portal.ncu.edu.tw/my/profile/password" target="_blank"
                                        rel="noopener noreferrer" class="external-link">中央大學 Portal <i
                                            class="bi bi-box-arrow-up-right ms-1"></i></a> 更改您的密碼。</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 刪除帳號 -->
                <div class="content-card content-card-danger mt-4">
                    <div class="content-card-header content-card-header-danger">
                        <h5 class="content-card-title">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            刪除帳號
                        </h5>
                    </div>
                    <div class="content-card-body">
                        <div class="alert-message">
                            <p>
                                <i class="bi bi-exclamation-circle"></i>
                                刪除您的帳號後，所有資源和數據將被永久刪除。在刪除帳號之前，請下載您希望保留的任何數據或信息。
                            </p>
                        </div>

                        <button type="button" class="btn btn-danger btn-with-icon mt-3" data-bs-toggle="modal"
                            data-bs-target="#deleteAccountModal">
                            <i class="bi bi-trash"></i>
                            <span>刪除帳號</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 刪除帳號確認模態框 -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAccountModalLabel">
                        <i class="bi bi-exclamation-octagon-fill text-danger me-2"></i>
                        確認刪除帳號
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <div class="modal-alert">
                            <div class="modal-alert-icon">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>
                            <div class="modal-alert-content">
                                <h6 class="text-danger mb-2">您確定要刪除您的帳號嗎？</h6>
                                <p>這個操作無法復原。您的所有數據將被永久刪除。</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="form-floating confirmation-input">
                                <input type="text"
                                    class="form-control @error('confirmation', 'userDeletion') is-invalid @enderror"
                                    id="confirmation" name="confirmation" required placeholder="請輸入刪除">
                                <label for="confirmation">請輸入「<span
                                        class="text-danger font-weight-bold">刪除</span>」以確認</label>
                                @error('confirmation', 'userDeletion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div id="confirmationFeedback" class="invalid-feedback">
                                    請輸入「刪除」以確認此操作
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">取消</button>
                        <button type="submit" id="deleteAccountBtn" class="btn btn-danger btn-with-icon" disabled>
                            <i class="bi bi-trash"></i>
                            <span>確認刪除</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Profile header with wave */
        .profile-header {
            background: linear-gradient(135deg, #004766, #006994, #0077be, #1e90ff);
            padding: 3rem 0;
            position: relative;
            margin-top: -1.5rem;
            overflow: hidden;
            border-radius: 0 0 20px 20px;
        }

        .header-content {
            position: relative;
            z-index: 10;
        }

        .bubble-container {
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .bubble {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            bottom: -50px;
            animation: bubble-rise var(--bubble-speed) ease-in infinite;
            opacity: 0;
        }

        .bubble-1 {
            --bubble-speed: 8s;
            width: 40px;
            height: 40px;
            left: 10%;
            animation-delay: 0.5s;
        }

        .bubble-2 {
            --bubble-speed: 12s;
            width: 20px;
            height: 20px;
            left: 20%;
            animation-delay: 1s;
        }

        .bubble-3 {
            --bubble-speed: 9s;
            width: 35px;
            height: 35px;
            left: 30%;
            animation-delay: 2s;
        }

        .bubble-4 {
            --bubble-speed: 15s;
            width: 50px;
            height: 50px;
            left: 40%;
            animation-delay: 0s;
        }

        .bubble-5 {
            --bubble-speed: 11s;
            width: 25px;
            height: 25px;
            left: 60%;
            animation-delay: 3s;
        }

        .bubble-6 {
            --bubble-speed: 10s;
            width: 30px;
            height: 30px;
            left: 80%;
            animation-delay: 1.5s;
        }

        .bubble-7 {
            --bubble-speed: 13s;
            width: 45px;
            height: 45px;
            left: 90%;
            animation-delay: 2.5s;
        }

        .bubble-8 {
            --bubble-speed: 7s;
            width: 15px;
            height: 15px;
            left: 70%;
            animation-delay: 0.2s;
        }

        @keyframes bubble-rise {
            0% {
                transform: translateY(0) scale(1);
                opacity: 0;
            }

            10% {
                opacity: 0.8;
            }

            100% {
                transform: translateY(-350px) scale(1.2);
                opacity: 0;
            }
        }

        /* Add subtle shimmer to header for underwater effect */
        .profile-header:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0.05) 50%,
                    rgba(255, 255, 255, 0) 100%);
            background-size: 200% 200%;
            animation: shimmer 5s linear infinite;
            z-index: -1;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        /* Remove existing wave-bottom styles */
        .wave-bottom {
            display: none;
        }

        /* User profile sidebar */
        .user-profile-sidebar {
            position: sticky;
            top: 1rem;
        }

        .profile-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 119, 190, 0.1);
            overflow: hidden;
            position: relative;
        }

        .profile-header-bg {
            height: 60px;
            background: linear-gradient(to right, #0077be, #1e90ff);
            position: relative;
            overflow: hidden;
            padding: 3rem 0;
            margin-top: -1.5rem;
        }

        .profile-avatar-wrapper {
            display: flex;
            justify-content: center;
            margin-top: -40px;
            position: relative;
        }

        .profile-avatar {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, #0077be, #1e90ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid #fff;
            box-shadow: 0 4px 15px rgba(0, 119, 190, 0.2);
            font-size: 40px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .profile-avatar-bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            animation: float-bubble 8s ease-in-out infinite;
        }

        .profile-avatar-bubble-1 {
            width: 20px;
            height: 20px;
            bottom: -5px;
            left: 15px;
            animation-delay: 0s;
        }

        .profile-avatar-bubble-2 {
            width: 15px;
            height: 15px;
            bottom: -5px;
            right: 20px;
            animation-delay: 2s;
        }

        .profile-avatar-bubble-3 {
            width: 10px;
            height: 10px;
            bottom: -5px;
            left: 40px;
            animation-delay: 1s;
        }

        @keyframes float-bubble {
            0% {
                transform: translateY(0);
                opacity: 0.2;
            }

            50% {
                transform: translateY(-30px);
                opacity: 0.8;
            }

            100% {
                transform: translateY(-60px);
                opacity: 0;
            }
        }

        .profile-info {
            padding: 1rem;
            text-align: center;
        }

        .profile-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .profile-email {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
        }

        .profile-meta {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-meta-item {
            display: flex;
            align-items: center;
            margin: 0 0.5rem;
            color: #0077be;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .profile-meta-item i {
            margin-right: 0.25rem;
        }

        /* Quick nav card */
        .quick-nav-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.25rem;
            box-shadow: 0 4px 20px rgba(0, 119, 190, 0.1);
        }

        .nav-card-title {
            color: #333;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .nav-card-title i {
            color: #0077be;
            margin-right: 0.5rem;
        }

        .nav-links {
            display: flex;
            flex-direction: column;
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            padding: 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            transition: all 0.2s ease;
            margin-bottom: 0.5rem;
        }

        .nav-link-item:hover {
            background-color: rgba(0, 119, 190, 0.05);
            color: #0077be;
            transform: translateX(5px);
        }

        .nav-link-item .nav-link-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background-color: rgba(0, 119, 190, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            color: #0077be;
            transition: all 0.2s ease;
        }

        .nav-link-item:hover .nav-link-icon {
            background-color: #0077be;
            color: white;
        }

        .nav-link-item span {
            flex-grow: 1;
        }

        .nav-link-item .bi-chevron-right {
            opacity: 0;
            transition: all 0.2s ease;
        }

        .nav-link-item:hover .bi-chevron-right {
            opacity: 1;
        }

        /* Content cards */
        .content-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 119, 190, 0.08);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .content-card:hover {
            box-shadow: 0 8px 30px rgba(0, 119, 190, 0.12);
        }

        .content-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 1.5rem;
            background: linear-gradient(to right, rgba(0, 119, 190, 0.05), rgba(0, 119, 190, 0));
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .content-card-title {
            color: #333;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .content-card-body {
            padding: 1.5rem;
        }

        /* Danger card styling */
        .content-card-danger {
            box-shadow: 0 4px 20px rgba(220, 53, 69, 0.08);
        }

        .content-card-header-danger {
            background: linear-gradient(to right, rgba(220, 53, 69, 0.05), rgba(220, 53, 69, 0));
            border-bottom: 1px solid rgba(220, 53, 69, 0.1);
        }

        .content-card-header-danger .content-card-title {
            color: #dc3545;
        }

        /* Form styling */
        .ocean-form .form-control,
        .ocean-form .form-select {
            border-radius: 8px;
            border: 1px solid rgba(0, 119, 190, 0.2);
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
        }

        .ocean-form .form-control:focus,
        .ocean-form .form-select:focus {
            border-color: #0077be;
            box-shadow: 0 0 0 0.25rem rgba(0, 119, 190, 0.25);
        }

        .ocean-form .form-floating label {
            padding-left: 1rem;
            padding-top: 0.9rem;
        }

        .ocean-form .form-floating>.form-control:focus~label,
        .ocean-form .form-floating>.form-control:not(:placeholder-shown)~label,
        .ocean-form .form-floating>.form-select~label {
            opacity: 0.65;
            transform: scale(0.85) translateY(-1rem) translateX(0.15rem);
        }

        .form-hint {
            font-size: 0.8rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }

        .form-actions {
            padding-top: 1.5rem;
            display: flex;
            align-items: center;
        }

        /* Button styling */
        .btn-ocean {
            background: linear-gradient(135deg, #0077be, #1e90ff);
            border: none;
            border-radius: 50px;
            padding: 0.75rem 2rem;
            color: white;
            font-weight: 500;
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .btn-ocean:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(0, 119, 190, 0.25);
            color: white;
        }

        .btn-with-icon {
            display: inline-flex;
            align-items: center;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-with-icon i {
            margin-right: 0.75rem;
            transition: all 0.3s ease;
        }

        .btn-with-icon:hover {
            transform: translateY(-2px);
        }

        .btn-with-icon:hover i {
            transform: translateX(-3px);
        }

        /* Notice box styling */
        .notice-box {
            display: flex;
            align-items: flex-start;
            background-color: rgba(0, 119, 190, 0.03);
            border-radius: 12px;
            padding: 1rem;
            border-left: 4px solid #0077be;
        }

        .notice-icon {
            color: #0077be;
            font-size: 1.25rem;
            margin-right: 1rem;
        }

        .notice-content {
            flex: 1;
        }

        .notice-content p {
            margin-bottom: 0;
        }

        .external-link {
            color: #0077be;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .external-link:hover {
            color: #005b8e;
            text-decoration: underline;
        }

        /* Alert message styling */
        .alert-message {
            background-color: rgba(220, 53, 69, 0.03);
            border-radius: 12px;
            padding: 1rem;
            border-left: 4px solid #dc3545;
        }

        .alert-message p {
            margin-bottom: 0;
            display: flex;
            align-items: center;
            color: #666;
        }

        .alert-message i {
            color: #dc3545;
            font-size: 1.25rem;
            margin-right: 0.75rem;
        }

        /* Success badge */
        .success-badge {
            background-color: #19875420;
            color: #198754;
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.4rem 0.75rem;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
        }

        /* Modal styling */
        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .modal-alert {
            display: flex;
            align-items: flex-start;
        }

        .modal-alert-icon {
            font-size: 1.75rem;
            color: #dc3545;
            margin-right: 1rem;
        }

        /* Email verification notice */
        .verification-notice {
            display: flex;
            align-items: center;
            background-color: #fff3cd;
            color: #856404;
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
        }

        .verification-notice i {
            margin-right: 0.5rem;
        }

        .resend-link {
            background: none;
            border: none;
            color: #0077be;
            padding: 0;
            margin-left: 0.5rem;
            font-size: 0.85rem;
            cursor: pointer;
            text-decoration: underline;
        }

        .verification-success {
            display: flex;
            align-items: center;
            background-color: #d4edda;
            color: #155724;
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
        }

        .verification-success i {
            margin-right: 0.5rem;
        }

        /* Wave button effect */
        .btn-ocean {
            position: relative;
            overflow: hidden;
        }

        .btn-wave {
            position: absolute;
            background: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0));
            height: 100%;
            width: 100px;
            top: 0;
            left: -100px;
            transform: skewX(-15deg);
            transition: 0.5s;
            filter: blur(3px);
        }

        .btn-ocean:hover .btn-wave {
            left: 150%;
        }

        .confirmation-input .form-control.is-valid {
            border-color: #28a745;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .confirmation-input .form-control.is-invalid {
            border-color: #dc3545;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        /* Shake animation for invalid input */
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: translateX(-5px);
            }

            20%,
            40%,
            60%,
            80% {
                transform: translateX(5px);
            }
        }

        .confirmation-input .form-control.is-invalid:focus {
            animation: shake 0.5s;
        }

        /* Styles for the required text */
        .confirmation-input label span {
            font-weight: 600;
        }

        /* Button transition */
        #deleteAccountBtn {
            transition: all 0.3s ease;
        }

        #deleteAccountBtn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .user-profile-sidebar {
                margin-bottom: 2rem;
                position: static;
            }
        }

        @media (max-width: 767px) {
            .profile-header {
                padding: 2rem 0 3rem;
            }

            .wave-bottom {
                height: 40px;
            }

            .content-card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .success-badge {
                margin-top: 0.5rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add input focus animation
            const formControls = document.querySelectorAll('.form-control, .form-select');

            formControls.forEach(control => {
                control.addEventListener('focus', function() {
                    this.parentElement.classList.add('input-focus');
                });

                control.addEventListener('blur', function() {
                    this.parentElement.classList.remove('input-focus');
                });
            });

            // Form validation visual feedback
            const form = document.querySelector('.ocean-form');

            if (form) {
                form.addEventListener('submit', function(event) {
                    if (!this.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    this.classList.add('was-validated');
                }, false);
            }

            const confirmationInput = document.getElementById('confirmation');
            const deleteAccountBtn = document.getElementById('deleteAccountBtn');

            if (confirmationInput && deleteAccountBtn) {
                confirmationInput.addEventListener('input', function() {
                    if (this.value === '刪除') {
                        deleteAccountBtn.disabled = false;
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        deleteAccountBtn.disabled = true;
                        this.classList.remove('is-valid');
                        if (this.value.length > 0) {
                            this.classList.add('is-invalid');
                        }
                    }
                });
            }
        });
    </script>
@endpush
