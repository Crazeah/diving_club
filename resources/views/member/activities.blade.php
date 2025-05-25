@extends('layouts.app')

@section('title', '我的活動')

@section('content')
    <div class="ocean-header">
        <div class="container header-content">
            <h1 class="text-white mb-0">我的活動</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-white-50">儀表板</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">我的活動</li>
                </ol>
            </nav>
        </div>
        <div class="bubble-container">
            <div class="bubble bubble-1"></div>
            <div class="bubble bubble-2"></div>
            <div class="bubble bubble-3"></div>
            <div class="bubble bubble-4"></div>
        </div>
    </div>

    <div class="container py-4">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="user-sidebar">
                    <div class="profile-stats-card">
                        <div class="stats-header">
                            <i class="bi bi-activity text-primary"></i>
                            <h5 class="stats-title">參與統計</h5>
                        </div>
                        <div class="stats-body">
                            <div class="stats-item">
                                <div class="stats-value">{{ $registrations->total() }}</div>
                                <div class="stats-label">已報名</div>
                            </div>
                            <div class="stats-item">
                                <div class="stats-value">{{ $registrations->where('status', 'approved')->count() }}</div>
                                <div class="stats-label">已核准</div>
                            </div>
                            <div class="stats-item">
                                <div class="stats-value">{{ $registrations->where('status', 'pending')->count() }}</div>
                                <div class="stats-label">審核中</div>
                            </div>
                        </div>
                    </div>

                    <div class="nav-card mt-4">
                        <div class="nav-header">
                            <i class="bi bi-person-lines-fill text-primary"></i>
                            <h5 class="nav-title">會員中心</h5>
                        </div>
                        <div class="nav-links">
                            <a href="{{ route('profile.edit') }}" class="nav-link-item">
                                <i class="bi bi-person-circle"></i>
                                <span>個人資料</span>
                            </a>
                            <a href="{{ route('member.activities') }}" class="nav-link-item active">
                                <i class="bi bi-calendar-event"></i>
                                <span>我的活動</span>
                            </a>
                            <a href="{{ route('member.comments') }}" class="nav-link-item">
                                <i class="bi bi-chat-dots"></i>
                                <span>我的評論</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="content-card">
                    <div class="content-card-header">
                        <div>
                            <h5 class="content-card-title mb-0">
                                <i class="bi bi-calendar-check text-primary me-2"></i>
                                已報名活動
                            </h5>
                            <p class="text-muted fs-sm mb-0">您目前共有 {{ $registrations->total() }} 個活動報名</p>
                        </div>
                        <a href="{{ route('activities.index') }}" class="btn btn-sm btn-outline-primary btn-ocean-outline">
                            <i class="bi bi-plus-lg"></i>
                            瀏覽更多活動
                        </a>
                    </div>

                    <div class="content-card-body p-0">
                        @forelse($registrations as $registration)
                            <div class="activity-list-item">
                                <div
                                    class="activity-status-indicator 
                            {{ $registration->status == 'pending'
                                ? 'status-pending'
                                : ($registration->status == 'approved'
                                    ? 'status-approved'
                                    : 'status-rejected') }}">
                                </div>
                                <div class="activity-content">
                                    <div class="activity-header">
                                        <h5 class="activity-title">{{ $registration->activity->title }}</h5>
                                        <span
                                            class="activity-badge 
                                    {{ $registration->status == 'pending'
                                        ? 'badge-pending'
                                        : ($registration->status == 'approved'
                                            ? 'badge-approved'
                                            : 'badge-rejected') }}">
                                            {{ $registration->status == 'pending' ? '審核中' : ($registration->status == 'approved' ? '已核准' : '已拒絕') }}
                                        </span>
                                    </div>

                                    <div class="activity-info">
                                        <div class="activity-info-item">
                                            <i class="bi bi-calendar-range"></i>
                                            <span>{{ $registration->activity->start_date->format('Y/m/d H:i') }} -
                                                {{ $registration->activity->end_date->format('Y/m/d H:i') }}</span>
                                        </div>
                                        <div class="activity-info-item">
                                            <i class="bi bi-geo-alt"></i>
                                            <span>{{ $registration->activity->location }}</span>
                                        </div>
                                        <div class="activity-info-item">
                                            <i class="bi bi-clock-history"></i>
                                            <span>報名時間：{{ $registration->created_at->format('Y/m/d H:i') }}</span>
                                        </div>
                                    </div>

                                    <div class="activity-actions">
                                        <a href="{{ route('activities.show', $registration->activity) }}"
                                            class="btn btn-sm btn-primary btn-ocean">
                                            <i class="bi bi-eye me-1"></i>
                                            查看活動
                                        </a>
                                        <form action="{{ route('activities.unregister', $registration->activity) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-danger btn-ocean-danger unregister-btn"
                                                data-activity="{{ $registration->activity->title }}">
                                                <i class="bi bi-x-circle me-1"></i>
                                                取消報名
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-calendar-x"></i>
                                </div>
                                <h4>尚未報名活動</h4>
                                <p>您目前尚未報名任何活動，立即瀏覽並報名參加！</p>
                                <a href="{{ route('activities.index') }}" class="btn btn-primary btn-ocean">
                                    <i class="bi bi-search me-2"></i>瀏覽可報名活動
                                </a>
                            </div>
                        @endforelse
                    </div>

                    @if ($registrations->hasPages())
                        <div class="content-card-footer">
                            {{ $registrations->links('pagination.custom') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- 取消報名確認模態框 -->
    <div class="modal fade" id="unregisterModal" tabindex="-1" aria-labelledby="unregisterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unregisterModalLabel">
                        <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                        確認取消報名
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>您確定要取消報名 <strong id="activityName"></strong> 嗎？</p>
                    <p class="text-muted">取消後若想重新參加，需再次報名並等待審核。</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">返回</button>
                    <button type="button" id="confirmUnregister" class="btn btn-danger btn-ocean-danger">
                        <i class="bi bi-trash me-2"></i>確認取消
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Ocean header styling */
        .ocean-header {
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

        /* Bubble animation */
        .bubble-container {
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
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
            left: 35%;
            animation-delay: 1s;
        }

        .bubble-3 {
            --bubble-speed: 9s;
            width: 35px;
            height: 35px;
            left: 60%;
            animation-delay: 2s;
        }

        .bubble-4 {
            --bubble-speed: 11s;
            width: 25px;
            height: 25px;
            left: 85%;
            animation-delay: 1.5s;
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

        /* User sidebar styling */
        .user-sidebar {
            position: sticky;
            top: 1rem;
        }

        .profile-stats-card {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 119, 190, 0.08);
            overflow: hidden;
        }

        .stats-header {
            padding: 1.25rem;
            background: linear-gradient(to right, rgba(0, 119, 190, 0.05), rgba(0, 119, 190, 0));
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
        }

        .stats-header i {
            font-size: 1.5rem;
            margin-right: 0.75rem;
        }

        .stats-title {
            margin: 0;
            font-weight: 600;
        }

        .stats-body {
            display: flex;
            padding: 1rem;
        }

        .stats-item {
            flex: 1;
            text-align: center;
        }

        .stats-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0077be;
        }

        .stats-label {
            font-size: 0.8rem;
            color: #6c757d;
        }

        /* Navigation card */
        .nav-card {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 119, 190, 0.08);
            overflow: hidden;
        }

        .nav-header {
            padding: 1.25rem;
            background: linear-gradient(to right, rgba(0, 119, 190, 0.05), rgba(0, 119, 190, 0));
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
        }

        .nav-header i {
            font-size: 1.5rem;
            margin-right: 0.75rem;
        }

        .nav-title {
            margin: 0;
            font-weight: 600;
        }

        .nav-links {
            padding: 0.75rem;
        }

        .nav-link-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #333;
            border-radius: 8px;
            margin-bottom: 0.25rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .nav-link-item i {
            font-size: 1.25rem;
            margin-right: 1rem;
            color: #0077be;
        }

        .nav-link-item:hover {
            background-color: rgba(0, 119, 190, 0.05);
            color: #0077be;
            transform: translateX(5px);
        }

        .nav-link-item.active {
            background-color: rgba(0, 119, 190, 0.1);
            color: #0077be;
            font-weight: 500;
        }

        /* Content card */
        .content-card {
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 119, 190, 0.08);
            overflow: hidden;
        }

        .content-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            background: linear-gradient(to right, rgba(0, 119, 190, 0.05), rgba(0, 119, 190, 0));
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .content-card-title {
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
        }

        .content-card-body {
            padding: 1.5rem;
        }

        .content-card-footer {
            padding: 1rem 1.5rem;
            background-color: #f8f9fa;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Activity list */
        .activity-list-item {
            display: flex;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            transition: all 0.3s ease;
        }

        .activity-list-item:last-child {
            border-bottom: none;
        }

        .activity-list-item:hover {
            background-color: rgba(0, 119, 190, 0.02);
        }

        .activity-status-indicator {
            width: 5px;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
        }

        .status-approved {
            background-color: #28a745;
        }

        .status-pending {
            background-color: #ffc107;
        }

        .status-rejected {
            background-color: #dc3545;
        }

        .activity-content {
            flex-grow: 1;
            padding: 1.5rem;
            margin-left: 5px;
        }

        .activity-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .activity-title {
            margin: 0;
            font-weight: 600;
        }

        .activity-badge {
            padding: 0.35rem 0.65rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-approved {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .badge-pending {
            background-color: rgba(255, 193, 7, 0.1);
            color: #856404;
        }

        .badge-rejected {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .activity-info {
            margin-bottom: 1rem;
        }

        .activity-info-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            color: #6c757d;
        }

        .activity-info-item i {
            font-size: 1rem;
            margin-right: 0.5rem;
            color: #0077be;
        }

        .activity-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            ;
        }

        /* Button styling */
        .btn-ocean {
            background: linear-gradient(135deg, #0077be, #1e90ff);
            border: none;
            border-radius: 50px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-ocean:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 119, 190, 0.2);
            color: white;
        }

        .btn-ocean-danger {
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #dc3545, #fd7e89);
            border: none;
            border-radius: 50px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-ocean-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.2);
            color: white;
        }

        .btn-ocean-outline {
            color: #0077be;
            border-color: #0077be;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-ocean-outline:hover {
            background-color: rgba(0, 119, 190, 0.1);
            color: #0077be;
            transform: translateY(-2px);
        }

        /* Empty state styling */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: #0077be;
            opacity: 0.2;
            margin-bottom: 1rem;
        }

        .empty-state h4 {
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .empty-state p {
            color: #6c757d;
            margin-bottom: 1.5rem;
            max-width: 300px;
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

        /* Utility classes */
        .fs-sm {
            font-size: 0.875rem;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .user-sidebar {
                margin-bottom: 2rem;
                position: static;
            }
        }

        @media (max-width: 767px) {
            .ocean-header {
                padding: 2rem 0 3rem;
            }

            .activity-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .activity-badge {
                margin-top: 0.5rem;
            }

            .activity-actions {
                flex-direction: column;
                width: 100%;
            }

            .activity-actions .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }

            .content-card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .content-card-header .btn {
                margin-top: 1rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle unregister button click
            const unregisterBtns = document.querySelectorAll('.unregister-btn');
            const activityNameEl = document.getElementById('activityName');
            const confirmUnregisterBtn = document.getElementById('confirmUnregister');
            let currentForm;

            unregisterBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const activityName = this.getAttribute('data-activity');
                    currentForm = this.closest('form');

                    // Set activity name in modal
                    activityNameEl.textContent = activityName;

                    // Show modal
                    const unregisterModal = new bootstrap.Modal(document.getElementById(
                        'unregisterModal'));
                    unregisterModal.show();
                });
            });

            // Handle confirm unregister
            confirmUnregisterBtn.addEventListener('click', function() {
                if (currentForm) {
                    currentForm.submit();
                }
            });

            // Animation for content cards
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.activity-list-item').forEach(item => {
                item.style.opacity = "0";
                item.style.transform = "translateY(20px)";
                item.style.transition = "opacity 0.5s ease, transform 0.5s ease";
                observer.observe(item);
            });

            // Animation class
            document.head.insertAdjacentHTML('beforeend', `
            <style>
                .fade-in {
                    opacity: 1 !important;
                    transform: translateY(0) !important;
                }
            </style>
        `);
        });
    </script>
@endpush
