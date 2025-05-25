@extends('layouts.app')

@section('title', '公告列表')

@section('content')
    <!-- Ocean-themed header -->
    <div class="ocean-header mb-4">
        <div class="container position-relative">
            <h1 class="display-4 text-white fw-bold ocean-title">公告列表</h1>
            <div class="ocean-subtitle">最新消息與重要通知</div>
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
            <div class="col-md-12">
                @if($pinnedAnnouncements->count() > 0)
                    <div class="mb-4">
                        <h4 class="section-title position-relative mb-3">
                            <i class="bi bi-pin-angle-fill me-2 text-primary"></i>置頂公告
                            <span class="section-line"></span>
                        </h4>
                        <div class="card-deck">
                            @foreach($pinnedAnnouncements as $announcement)
                                <div class="card announcement-card mb-3 pinned-card">
                                    <div class="card-body position-relative">
                                        <div class="pinned-badge">
                                            <i class="bi bi-pin-angle-fill"></i>
                                        </div>
                                        <h5 class="card-title text-primary fw-bold mb-3">
                                            {{ $announcement->title }}
                                        </h5>
                                        <p class="card-text announcement-content">
                                            {{ Str::limit(strip_tags($announcement->content), 150) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center announcement-meta">
                                            <div>
                                                <i class="bi bi-person-fill me-1"></i>
                                                <small>{{ $announcement->user->name }}</small>
                                            </div>
                                            <div>
                                                <i class="bi bi-calendar3 me-1"></i>
                                                <small>{{ $announcement->published_at->format('Y/m/d') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer border-0 bg-transparent text-end">
                                        <a href="{{ route('announcements.show', $announcement) }}" class="btn btn-sm btn-outline-ocean">
                                            閱讀更多 <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <h4 class="section-title position-relative mb-3">
                    <i class="bi bi-megaphone-fill me-2 text-primary"></i>一般公告
                    <span class="section-line"></span>
                </h4>
                
                <div class="announcement-list">
                    @forelse($announcements as $announcement)
                        <div class="announcement-item">
                            <a href="{{ route('announcements.show', $announcement) }}" class="announcement-link">
                                <div class="card announcement-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="card-title mb-0">{{ $announcement->title }}</h5>
                                            <span class="announcement-date badge bg-light text-dark">
                                                {{ $announcement->published_at->format('Y/m/d') }}
                                            </span>
                                        </div>
                                        <p class="card-text announcement-content">
                                            {{ Str::limit(strip_tags($announcement->content), 150) }}
                                        </p>
                                        <div class="text-muted">
                                            <small><i class="bi bi-person-fill me-1"></i>{{ $announcement->user->name }}</small>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="alert alert-info border-0 shadow-sm">
                            <i class="bi bi-info-circle-fill me-2"></i>目前沒有公告
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-4 d-flex justify-content-center">
                    {{ $announcements->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Ocean-themed header styles */
    .ocean-header {
        background: linear-gradient(135deg, #004766, #006994, #0077be, #1e90ff);
        position: relative;
        overflow: hidden;
        padding: 5rem 0 3rem;
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
    
    /* Section title styling */
    .section-title {
        color: #006994;
        font-weight: 600;
        display: inline-block;
        padding-bottom: 5px;
    }
    
    .section-line {
        display: block;
        width: 100%;
        height: 3px;
        background: linear-gradient(to right, #006994, #1e90ff, transparent);
        margin-top: 5px;
        border-radius: 2px;
    }
    
    /* Announcement cards styling */
    .announcement-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }
    
    .announcement-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 119, 190, 0.1);
    }
    
    .pinned-card {
        border-left: 4px solid #0077be;
        background-color: rgba(0, 119, 190, 0.03);
    }
    
    .pinned-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        color: #dc3545;
        font-size: 1.2rem;
    }
    
    .announcement-content {
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 1rem;
    }
    
    .announcement-meta {
        color: #6c757d;
        font-size: 0.85rem;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
        padding-top: 1rem;
    }
    
    .announcement-date {
        font-size: 0.8rem;
        font-weight: normal;
        padding: 0.3rem 0.7rem;
        background-color: rgba(0, 119, 190, 0.1);
        color: #0077be;
    }
    
    /* Announcement list styling */
    .announcement-list {
        margin-bottom: 2rem;
    }
    
    .announcement-item {
        margin-bottom: 1rem;
    }
    
    .announcement-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    
    .announcement-link:hover {
        color: inherit;
    }
    
    /* Button styling */
    .btn-outline-ocean {
        color: #0077be;
        border-color: #0077be;
        border-radius: 50px;
        padding: 0.3rem 1.2rem;
        transition: all 0.3s ease;
    }
    
    .btn-outline-ocean:hover {
        background: linear-gradient(135deg, #0077be, #1e90ff);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 119, 190, 0.3);
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
    
    /* Pagination styling */
    .pagination {
        --bs-pagination-active-bg: #0077be;
        --bs-pagination-active-border-color: #0077be;
        --bs-pagination-color: #0077be;
        --bs-pagination-hover-color: #0077be;
        --bs-pagination-focus-color: #0077be;
        --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(0, 119, 190, 0.25);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .ocean-header {
            padding: 4rem 0 2rem;
        }
        
        .ocean-title {
            font-size: 2rem;
        }
        
        .ocean-subtitle {
            font-size: 1rem;
        }
        
        .pinned-badge {
            font-size: 1rem;
        }
    }
</style>
@endpush