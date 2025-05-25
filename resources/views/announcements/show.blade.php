@extends('layouts.app')

@section('title', $announcement->title)

@section('content')
<!-- Ocean-themed header -->
<div class="ocean-header announcement-header mb-4">
    <div class="container position-relative">
        <div class="announcement-header-content">
            @if($announcement->is_pinned)
            <div class="pinned-ribbon">
                <span><i class="bi bi-pin-angle-fill"></i> 置頂公告</span>
            </div>
            @endif
            <h1 class="display-5 text-white fw-bold ocean-title">{{ $announcement->title }}</h1>
            <div class="announcement-meta d-flex flex-wrap align-items-center">
                <div class="meta-item">
                    <i class="bi bi-calendar3"></i>
                    {{ $announcement->published_at->format('Y/m/d H:i') }}
                </div>
                <div class="meta-divider"></div>
                <div class="meta-item">
                    <i class="bi bi-person-fill"></i>
                    {{ $announcement->user->name }}
                </div>
            </div>
        </div>
    </div>
    <div class="floating-elements">
        <div class="bubble bubble-1"></div>
        <div class="bubble bubble-2"></div>
        <div class="bubble bubble-3"></div>
    </div>
</div>

<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card ocean-card announcement-detail-card">
                <div class="card-body p-md-5 p-4">
                    <div class="announcement-content">
                        {!! $announcement->content !!}
                    </div>
                    
                    @if($announcement->attachments && $announcement->attachments->count() > 0)
                    <div class="announcement-attachments mt-5">
                        <h5 class="attachments-title">
                            <i class="bi bi-paperclip"></i> 附件檔案
                        </h5>
                        <div class="list-group attachments-list">
                            @foreach($announcement->attachments as $attachment)
                            <a href="{{ route('attachments.download', $attachment) }}" class="list-group-item list-group-item-action attachment-item">
                                <div class="attachment-icon">
                                    <i class="bi bi-file-earmark"></i>
                                </div>
                                <div class="attachment-info">
                                    <div class="attachment-name">{{ $attachment->original_filename }}</div>
                                    <div class="attachment-meta">
                                        <span>{{ $attachment->size_formatted }}</span>
                                        <span class="attachment-type">{{ $attachment->mime_type }}</span>
                                    </div>
                                </div>
                                <div class="attachment-download">
                                    <i class="bi bi-download"></i>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                
                <div class="card-footer ocean-card-footer p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <a href="{{ route('announcements.index') }}" class="btn btn-outline-ocean me-2 mb-2 mb-md-0">
                            <i class="bi bi-arrow-left me-1"></i> 返回公告列表
                        </a>
                        
                        <div class="announcement-actions">
                            <button class="btn btn-light btn-share" data-bs-toggle="tooltip" title="分享公告">
                                <i class="bi bi-share-fill"></i>
                            </button>
                            
                            <button class="btn btn-light btn-print" onclick="window.print()" data-bs-toggle="tooltip" title="列印公告">
                                <i class="bi bi-printer-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related announcements -->
            @if(isset($relatedAnnouncements) && $relatedAnnouncements->count() > 0)
            <div class="related-announcements mt-4">
                <h4 class="section-title position-relative mb-3">
                    <i class="bi bi-link-45deg me-2 text-primary"></i>相關公告
                    <span class="section-line"></span>
                </h4>
                
                <div class="row g-3">
                    @foreach($relatedAnnouncements as $related)
                    <div class="col-md-6">
                        <a href="{{ route('announcements.show', $related) }}" class="related-announcement-card">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $related->title }}</h6>
                                    <p class="card-text small text-muted">
                                        {{ Str::limit(strip_tags($related->content), 80) }}
                                    </p>
                                    <div class="card-meta small">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $related->published_at->format('Y/m/d') }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Ocean-themed header */
    .ocean-header {
        background: linear-gradient(135deg, #004766, #006994, #0077be, #1e90ff);
        position: relative;
        overflow: hidden;
        margin-top: -1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 0 0 20px 20px;
    }
    
    .announcement-header {
        padding: 5rem 0 3rem;
    }
    
    .announcement-header-content {
        position: relative;
        z-index: 2;
        padding-right: 1rem;
    }
    
    .ocean-title {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        margin-bottom: 1rem;
        line-height: 1.3;
    }
    
    .announcement-meta {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        padding: 0.25rem 0;
    }
    
    .meta-item i {
        margin-right: 0.5rem;
        font-size: 1.1rem;
    }
    
    .meta-divider {
        width: 1px;
        height: 20px;
        background-color: rgba(255, 255, 255, 0.4);
        margin: 0 1rem;
    }
    
    /* Pinned ribbon */
    .pinned-ribbon {
        position: absolute;
        top: 0;
        right: 0;
        background: linear-gradient(135deg, #ff3e3e, #ff6b6b);
        color: white;
        padding: 0.5rem 2rem 0.5rem 1.5rem;
        font-weight: 600;
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%, 10% 50%);
        box-shadow: 0 2px 10px rgba(255, 62, 62, 0.3);
        transform: translateX(1rem);
    }
    
    .pinned-ribbon span {
        display: flex;
        align-items: center;
    }
    
    .pinned-ribbon i {
        margin-right: 0.4rem;
    }
    
    /* Announcement detail card */
    .ocean-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 119, 190, 0.1);
        background: linear-gradient(to bottom right, #ffffff, #f8fcff);
        transition: all 0.3s ease;
    }
    
    .ocean-card:hover {
        box-shadow: 0 15px 35px rgba(0, 119, 190, 0.15);
    }
    
    .announcement-content {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #3a4a5a;
    }
    
    .announcement-content h1, 
    .announcement-content h2, 
    .announcement-content h3,
    .announcement-content h4,
    .announcement-content h5,
    .announcement-content h6 {
        color: #006994;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .announcement-content p {
        margin-bottom: 1.2rem;
    }
    
    .announcement-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
    
    .announcement-content blockquote {
        border-left: 4px solid #0077be;
        padding: 0.5rem 0 0.5rem 1.5rem;
        margin: 1.5rem 0;
        background-color: rgba(0, 119, 190, 0.05);
        border-radius: 4px;
    }
    
    .ocean-card-footer {
        background-color: rgba(0, 119, 190, 0.03);
        border-top: 1px solid rgba(0, 119, 190, 0.08);
    }
    
    /* Attachments styling */
    .attachments-title {
        font-weight: 600;
        color: #006994;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(0, 119, 190, 0.1);
    }
    
    .attachment-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        margin-bottom: 0.5rem;
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .attachment-item:hover {
        background-color: rgba(0, 119, 190, 0.05);
        transform: translateY(-2px);
    }
    
    .attachment-icon {
        width: 40px;
        height: 40px;
        background-color: rgba(0, 119, 190, 0.1);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0077be;
        font-size: 1.2rem;
        margin-right: 1rem;
    }
    
    .attachment-info {
        flex-grow: 1;
    }
    
    .attachment-name {
        font-weight: 500;
        color: #3a4a5a;
    }
    
    .attachment-meta {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }
    
    .attachment-type {
        margin-left: 0.5rem;
        padding: 0.15rem 0.5rem;
        background-color: rgba(0, 0, 0, 0.05);
        border-radius: 4px;
    }
    
    .attachment-download {
        color: #0077be;
        font-size: 1.2rem;
    }
    
    /* Button styling */
    .btn-outline-ocean {
        color: #0077be;
        border: 2px solid #0077be;
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-outline-ocean:hover {
        background: linear-gradient(135deg, #0077be, #1e90ff);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 119, 190, 0.3);
    }
    
    .announcement-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .announcement-actions .btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        color: #0077be;
        border: 1px solid rgba(0, 119, 190, 0.2);
    }
    
    .announcement-actions .btn:hover {
        background-color: #0077be;
        color: white;
        transform: translateY(-2px);
    }
    
    /* Related announcements */
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
    
    .related-announcement-card {
        text-decoration: none;
        color: inherit;
        display: block;
        transition: all 0.3s ease;
    }
    
    .related-announcement-card .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .related-announcement-card:hover {
        transform: translateY(-5px);
    }
    
    .related-announcement-card:hover .card {
        box-shadow: 0 10px 20px rgba(0, 119, 190, 0.1);
        border-left: 3px solid #0077be;
    }
    
    .related-announcement-card .card-title {
        color: #006994;
        font-weight: 600;
    }
    
    .related-announcement-card:hover .card-title {
        color: #0077be;
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
    
    /* Print media query */
    @media print {
        .ocean-header, .announcement-actions, .related-announcements {
            display: none;
        }
        
        .ocean-card {
            box-shadow: none !important;
            border: 1px solid #ddd;
        }
        
        .container {
            max-width: 100%;
            width: 100%;
        }
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .announcement-header {
            padding: 4rem 0 2rem;
        }
        
        .ocean-title {
            font-size: 1.75rem;
        }
        
        .announcement-meta {
            font-size: 0.9rem;
        }
        
        .pinned-ribbon {
            font-size: 0.85rem;
            padding: 0.4rem 1.5rem 0.4rem 1rem;
        }
        
        .meta-divider {
            margin: 0 0.5rem;
        }
        
        .announcement-content {
            font-size: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Share functionality
        document.querySelector('.btn-share')?.addEventListener('click', function() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $announcement->title }}',
                    text: '查看這則公告',
                    url: window.location.href
                })
                .catch(console.error);
            } else {
                // Fallback copy to clipboard
                const textarea = document.createElement('textarea');
                textarea.value = window.location.href;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                
                alert('公告連結已複製到剪貼簿');
            }
        });
    });
</script>
@endpush