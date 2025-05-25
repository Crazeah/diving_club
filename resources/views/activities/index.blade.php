@extends('layouts.app')

@section('title', '活動列表')

@section('content')
    <!-- Ocean-themed header -->
    <div class="ocean-header mb-4">
        <div class="container position-relative">
            <h1 class="display-4 text-white fw-bold ocean-title">活動列表</h1>
            <div class="ocean-subtitle">探索潛水的奇妙世界</div>
        </div>
        <div class="floating-elements">
            <div class="bubble bubble-1"></div>
            <div class="bubble bubble-2"></div>
            <div class="bubble bubble-3"></div>
            <div class="bubble bubble-4"></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Category filters with aquatic styling -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm category-card">
                    <div class="card-header bg-gradient-ocean text-white">
                        <i class="bi bi-funnel-fill me-2"></i>分類篩選
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('activities.index') }}"
                                class="list-group-item list-group-item-action d-flex align-items-center {{ !request('category') ? 'active' : '' }}">
                                <div class="bubble-icon me-2">
                                    <i class="bi bi-grid-3x3-gap"></i>
                                </div>
                                全部活動
                            </a>
                            @foreach ($categories as $category)
                                <a href="{{ route('activities.index', ['category' => $category->slug]) }}"
                                    class="list-group-item list-group-item-action d-flex align-items-center {{ request('category') == $category->slug ? 'active' : '' }}">
                                    <div class="bubble-icon me-2">
                                        <i class="bi bi-tag"></i>
                                    </div>
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity cards with aquatic styling -->
            <div class="col-lg-9">
                <div class="row g-4">
                    @forelse($activities as $activity)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 activity-card border-0 shadow-sm">
                                <div class="card-body position-relative">
                                    <div class="activity-icon">
                                        <i class="bi bi-water"></i>
                                    </div>
                                    <h5 class="card-title text-primary fw-bold">{{ $activity->title }}</h5>
                                    <p class="card-text text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $activity->start_date->format('Y/m/d H:i') }}
                                        <br>
                                        <i class="bi bi-geo-alt-fill me-1"></i> {{ $activity->location }}
                                    </p>
                                    <span class="badge bg-info rounded-pill">
                                        <i class="bi bi-chat-dots-fill me-1"></i> {{ $activity->approved_comment_count }}
                                    </span>
                                    <div class="mt-3 card-description">
                                        {{ Str::limit($activity->description, 100) }}
                                    </div>
                                </div>
                                <div class="card-footer border-0 bg-transparent">
                                    <a href="{{ route('activities.show', $activity) }}" class="btn btn-ocean w-100">
                                        查看詳情 <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info border-0 shadow-sm">
                                <i class="bi bi-info-circle-fill me-2"></i>目前沒有活動
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $activities->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Ocean theme custom styles */
        .ocean-header {
            background: linear-gradient(135deg, #004766, #006994, #0077be, #1e90ff);
            position: relative;
            overflow: hidden;
            padding: 7rem 0 4rem;
            margin-top: -1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 0 0 20px 20px;
        }

        .ocean-title {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 2;
            margin-bottom: 0.5rem;
        }

        .ocean-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
        }

        /* Floating bubble animations */
        .floating-elements {
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
            animation: float 8s ease-in-out infinite;
        }

        .bubble-1 {
            width: 30px;
            height: 30px;
            left: 10%;
            top: 40%;
            animation-delay: 0s;
            animation-duration: 6s;
        }

        .bubble-2 {
            width: 20px;
            height: 20px;
            left: 25%;
            top: 30%;
            animation-delay: 1s;
            animation-duration: 7s;
        }

        .bubble-3 {
            width: 35px;
            height: 35px;
            right: 30%;
            top: 50%;
            animation-delay: 2s;
            animation-duration: 8s;
        }

        .bubble-4 {
            width: 25px;
            height: 25px;
            right: 10%;
            top: 35%;
            animation-delay: 3s;
            animation-duration: 5s;
        }

        @keyframes float {
            0% {
                transform: translateY(0);
                opacity: 0.2;
            }

            50% {
                transform: translateY(-40px);
                opacity: 0.8;
            }

            100% {
                transform: translateY(-80px);
                opacity: 0;
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .ocean-header {
                padding: 4.5rem 0 2.5rem;
            }

            .ocean-title {
                font-size: 2rem;
            }

            .ocean-subtitle {
                font-size: 1rem;
            }
        }

        .bg-gradient-ocean {
            background: linear-gradient(135deg, #006994, #0077be);
        }

        .btn-ocean {
            background: linear-gradient(135deg, #0077be, #1e90ff);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-ocean:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 119, 190, 0.4);
            color: white;
        }

        .btn-ocean:active {
            transform: translateY(-1px);
        }

        .category-card {
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .list-group-item {
            border-left: none;
            border-right: none;
            padding: 0.8rem 1.25rem;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .list-group-item.active {
            background: linear-gradient(135deg, #0077be, #1e90ff);
            border-color: transparent;
        }

        .bubble-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: rgba(0, 119, 190, 0.1);
            color: #0077be;
        }

        .list-group-item.active .bubble-icon {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .activity-card {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .activity-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .activity-icon {
            position: absolute;
            top: 10px;
            right: 10px;
            color: rgba(0, 119, 190, 0.2);
            font-size: 24px;
        }

        .card-description {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .card-title {
            width: 90%;
        }

        /* Override Bootstrap pagination */
        .pagination {
            --bs-pagination-active-bg: #0077be;
            --bs-pagination-active-border-color: #0077be;
            --bs-pagination-color: #0077be;
            --bs-pagination-hover-color: #0077be;
            --bs-pagination-focus-color: #0077be;
            --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(0, 119, 190, 0.25);
        }
    </style>
@endpush