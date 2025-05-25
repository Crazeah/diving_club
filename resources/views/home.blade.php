@extends('layouts.app')

@section('title', '首頁')

@section('content')
<!-- 輪播橫幅 -->
<div id="carouselExampleIndicators" class="carousel slide carousel-fade shadow-sm rounded mb-4" data-bs-ride="carousel" style="height: 400px; overflow: hidden;">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner h-100">
        <div class="carousel-item active h-100">
            <img src="{{ asset('images/slide1.jpg') }}" class="d-block w-100" alt="Slide 1" style="object-fit: cover; height: 100%; filter: brightness(0.8);">
            <div class="carousel-caption d-flex flex-column justify-content-center align-items-start h-100" style="left: 10%; right: auto; top: 0; bottom: 0;">
                <h2 class="fw-bold text-white text-shadow">探索海洋世界</h2>
                <p class="lead text-white text-shadow mb-4">與我們一起展開水下冒險之旅</p>
                <div class="d-flex">
                    <a class="btn btn-primary btn-lg me-2" href="{{ route('activities.index') }}">瀏覽活動</a>
                    @guest
                    <a class="btn btn-outline-light btn-lg" href="{{ route('register') }}">立即註冊</a>
                    @endguest
                </div>
            </div>
        </div>
        <div class="carousel-item h-100">
            <img src="{{ asset('images/slide2.jpg') }}" class="d-block w-100" alt="Slide 2" style="object-fit: cover; height: 100%; filter: brightness(0.8);">
            <div class="carousel-caption d-flex flex-column justify-content-center align-items-start h-100" style="left: 10%; right: auto; top: 0; bottom: 0;">
                <h2 class="fw-bold text-white text-shadow">專業潛水課程</h2>
                <p class="lead text-white text-shadow mb-4">安全、專業的潛水教學體驗</p>
                <div class="d-flex">
                    <a class="btn btn-primary btn-lg me-2" href="{{ route('activities.index') }}">課程介紹</a>
                </div>
            </div>
        </div>
        <div class="carousel-item h-100">
            <img src="{{ asset('images/slide3.jpg') }}" class="d-block w-100" alt="Slide 3" style="object-fit: cover; height: 100%; filter: brightness(0.8);">
            <div class="carousel-caption d-flex flex-column justify-content-center align-items-start h-100" style="left: 10%; right: auto; top: 0; bottom: 0;">
                <h2 class="fw-bold text-white text-shadow">海洋保育活動</h2>
                <p class="lead text-white text-shadow mb-4">守護美麗的海洋生態環境</p>
                <div class="d-flex">
                    <a class="btn btn-primary btn-lg me-2" href="{{ route('activities.index') }}">參與活動</a>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">上一張</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">下一張</span>
    </button>
</div>

<div class="container py-4">
    

    <!-- 行事曆區塊 (幾乎不變) -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="border-start border-primary border-4 ps-3">每月活動行事曆</h2>
                <div class="d-flex align-items-center">
                    <a href="{{ route('home', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}" class="btn btn-outline-primary btn-sm me-2">
                        <i class="bi bi-chevron-left"></i> 上個月
                    </a>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 fs-5 rounded-pill">{{ $currentMonth->format('Y年m月') }}</span>
                    <a href="{{ route('home', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}" class="btn btn-outline-primary btn-sm ms-2">
                        下個月 <i class="bi bi-chevron-right"></i>
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm ms-2">
                        <i class="bi bi-calendar-event"></i> 今天
                    </a>
                </div>
            </div>

            <div class="card calendar-card shadow-sm">
                <div class="card-body">
                    <table class="table table-bordered calendar-table table-fixed">
                        <thead>
                            <tr class="text-center">
                                <th>週日</th>
                                <th>週一</th>
                                <th>週二</th>
                                <th>週三</th>
                                <th>週四</th>
                                <th>週五</th>
                                <th>週六</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $day = $startOfCalendar->copy();
                            @endphp

                            @while ($day <= $endOfCalendar)
                                @if ($day->dayOfWeek === 0)
                                    <tr>
                                @endif

                                <td class="calendar-day {{ $day->month !== $currentMonth->month ? 'text-muted' : '' }} {{ $day->isToday() ? 'bg-light' : '' }}">
                                    <div class="date-header fw-bold">{{ $day->day }}</div>

                                    <div class="calendar-events">
                                        @if(isset($calendarActivities[$day->format('Y-m-d')]))
                                            @foreach($calendarActivities[$day->format('Y-m-d')] as $activity)
                                                <div class="calendar-event">
                                                    <a href="{{ route('activities.show', $activity) }}" class="badge bg-primary w-100">
                                                        {{ $activity->title }}
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <!-- 填充空白活動區，保持一致的高度 -->
                                            <div class="calendar-event">
                                                <span class="empty-event">&nbsp;</span>
                                            </div>
                                            <div class="calendar-event">
                                                <span class="empty-event">&nbsp;</span>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                @if ($day->dayOfWeek === 6)
                                    </tr>
                                @endif

                                @php
                                    $day->addDay();
                                @endphp
                            @endwhile
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 數字統計區塊 -->
    <div class="row mb-5 g-4 text-center">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 py-3">
                <div class="card-body">
                    <div class="text-primary mb-2">
                        <i class="bi bi-calendar-event fs-1"></i>
                    </div>
                    <h3 class="fw-bold">{{ App\Models\Activity::count() }}+</h3>
                    <p class="text-muted mb-0">舉辦活動</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 py-3">
                <div class="card-body">
                    <div class="text-success mb-2">
                        <i class="bi bi-people fs-1"></i>
                    </div>
                    <h3 class="fw-bold">{{ App\Models\User::count() }}+</h3>
                    <p class="text-muted mb-0">註冊會員</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 py-3">
                <div class="card-body">
                    <div class="text-warning mb-2">
                        <i class="bi bi-award fs-1"></i>
                    </div>
                    <h3 class="fw-bold">5+</h3>
                    <p class="text-muted mb-0">專業認證</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 py-3">
                <div class="card-body">
                    <div class="text-danger mb-2">
                        <i class="bi bi-geo-alt fs-1"></i>
                    </div>
                    <h3 class="fw-bold">12+</h3>
                    <p class="text-muted mb-0">潛水地點</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 最新活動 -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="border-start border-success border-4 ps-3">最新活動</h2>
                <a href="{{ route('activities.index') }}" class="btn btn-outline-success">
                    查看全部 <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="row g-4">
                @forelse($latestActivities as $activity)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center" 
                             style="background-color: #3a86ff;">
                            <div>
                                <span class="fw-bold fs-5">{{ $activity->start_date->format('m/d') }}</span>
                                <small>{{ $activity->start_date->format('H:i') }}</small>
                            </div>
                            <div>
                                @if($activity->registration_deadline && $activity->registration_deadline > now())
                                    <span class="badge bg-success">報名中</span>
                                @elseif($activity->start_date > now())
                                    <span class="badge bg-warning text-dark">即將開始</span>
                                @else
                                    <span class="badge bg-secondary">已結束</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $activity->title }}</h5>
                            <div class="text-muted mb-3 small">
                                <div class="mb-1"><i class="bi bi-geo-alt me-1"></i> {{ Str::limit($activity->location, 20) }}</div>
                                <div><i class="bi bi-people me-1"></i> {{ $activity->registrations->count() }}/{{ $activity->max_participants ?? '∞' }}</div>
                            </div>
                            <p class="card-text">{{ Str::limit($activity->description, 100) }}</p>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <a href="{{ route('activities.show', $activity) }}" class="btn btn-primary w-100">查看詳情</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                        <div>目前沒有活動，請稍後再查看。</div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- 公告區域與側邊欄 -->
    <div class="row g-4">
        <!-- 公告區域 -->
        <div class="col-md-8 mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="border-start border-warning border-4 ps-3">最新公告</h2>
                <a href="{{ route('announcements.index') }}" class="btn btn-outline-warning">
                    查看全部 <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            
            <!-- 置頂公告 -->
            @if(isset($pinnedAnnouncements) && $pinnedAnnouncements->count() > 0)
            <div class="mb-4">
                @foreach($pinnedAnnouncements as $announcement)
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-warning text-dark me-2">置頂</span>
                            <h5 class="mb-0">{{ $announcement->title }}</h5>
                            <small class="text-muted ms-auto">{{ $announcement->published_at->format('Y/m/d') }}</small>
                        </div>
                        <p class="card-text">{{ Str::limit(strip_tags($announcement->content), 150) }}</p>
                        <a href="{{ route('announcements.show', $announcement) }}" class="btn btn-sm btn-warning">
                            閱讀更多 <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            
            <!-- 一般公告 -->
            <div class="list-group shadow-sm">
                @forelse($latestAnnouncements as $announcement)
                <a href="{{ route('announcements.show', $announcement) }}" class="list-group-item list-group-item-action border-0 mb-2 rounded">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">{{ $announcement->title }}</h5>
                        <small class="text-muted">{{ $announcement->published_at->format('Y/m/d') }}</small>
                    </div>
                    <p class="mb-1">{{ Str::limit(strip_tags($announcement->content), 150) }}</p>
                    <small class="text-primary">閱讀更多 <i class="bi bi-arrow-right"></i></small>
                </a>
                @empty
                @if(!isset($pinnedAnnouncements) || $pinnedAnnouncements->count() == 0)
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                    <div>目前沒有公告，請稍後再查看。</div>
                </div>
                @endif
                @endforelse
            </div>
        </div>
        
        <!-- 側邊欄 -->
        <div class="col-md-4 mb-5">
            <!-- 關於潛水社 -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>關於潛水社</h5>
                </div>
                <div class="card-body">
                    <p>潛水社成立於2010年，致力於推廣潛水運動及海洋保育教育。我們提供專業的潛水課程、多元的潛水活動，以及結合海洋保育的教育計劃。</p>
                    
                    <div class="mt-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-primary rounded-circle p-2 me-3 text-white">
                                <i class="bi bi-award"></i>
                            </div>
                            <div>專業認證課程</div>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success rounded-circle p-2 me-3 text-white">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div>安全第一理念</div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-warning rounded-circle p-2 me-3 text-white">
                                <i class="bi bi-heart"></i>
                            </div>
                            <div>海洋保育推廣</div>
                        </div>
                    </div>
                    
                    @guest
                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('register') }}" class="btn btn-primary">立即註冊</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary">會員登入</a>
                    </div>
                    @endguest
                </div>
            </div>
            
            <!-- 會員福利 -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-success text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-gift me-2"></i>會員福利</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center border-0">
                            <div class="bg-primary rounded-circle p-2 me-3 text-white">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div>
                                <strong>優先報名</strong><br>
                                <small class="text-muted">熱門活動優先報名權</small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center border-0">
                            <div class="bg-danger rounded-circle p-2 me-3 text-white">
                                <i class="bi bi-percent"></i>
                            </div>
                            <div>
                                <strong>專屬折扣</strong><br>
                                <small class="text-muted">潛水裝備購買優惠</small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center border-0">
                            <div class="bg-warning rounded-circle p-2 me-3 text-white">
                                <i class="bi bi-people"></i>
                            </div>
                            <div>
                                <strong>專屬社群</strong><br>
                                <small class="text-muted">會員專屬交流群組</small>
                            </div>
                        </li>
                        <li class="list-group-item d-flex align-items-center border-0">
                            <div class="bg-info rounded-circle p-2 me-3 text-white">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                            <div>
                                <strong>免費講座</strong><br>
                                <small class="text-muted">海洋知識免費講座</small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* 保留並微調行事曆樣式 */
    .table-fixed {
        table-layout: fixed;
        width: 100%;
    }
    
    .calendar-card {
        background-image: url('{{ asset('images/beach.jpg') }}');
        background-size: cover;
        background-position: center;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .calendar-card .card-body {
        background-color: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(1px);
        padding: 20px;
    }
    
    .calendar-table th, .calendar-table td {
        background-color: transparent !important;
    }
    
    .calendar-day.text-muted {
        background-color: transparent !important;
        color: transparent !important;
        pointer-events: none;
    }
    
    .calendar-day {
        background-color: rgba(255, 255, 255, 0.3);
        height: 90px;
        padding: 4px;
        transition: transform 0.2s, background-color 0.2s;
    }
    
    .calendar-day:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .calendar-day.bg-light {
        background-color: rgba(200, 200, 200, 0.85) !important;
    }
    
    .calendar-events {
        margin-top: 5px;
    }
    
    .calendar-event .badge {
        white-space: normal;
        line-height: 1.2;
        font-size: 0.75rem;
        display: block;
        transition: all 0.2s;
    }
    
    .calendar-event .badge:hover {
        transform: translateY(-1px);
    }
    
    .date-header {
        text-align: right;
        padding-right: 5px;
    }
    
    /* 文字陰影 */
    .text-shadow {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 初始化輪播
    var myCarousel = document.getElementById('carouselExampleIndicators');
    if (myCarousel) {
        new bootstrap.Carousel(myCarousel, {
            interval: 5000,  // 設定為 5000 毫秒，即 5 秒
            wrap: true,
            keyboard: true
        });
    }
    
    // 獲取 DOM 元素
    const calendarContainer = document.getElementById('calendar-container');
    const prevMonthBtn = document.getElementById('prev-month');
    const nextMonthBtn = document.getElementById('next-month');
    const todayBtn = document.getElementById('today-btn');
    const currentMonthDisplay = document.getElementById('current-month-display');
    
    // 異步獲取日曆數據
    function loadCalendar(year, month) {
        // 顯示載入中提示
        if (calendarContainer) {
            calendarContainer.innerHTML = '<div class="loader"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">載入中...</p></div>';
            
            // 發送 AJAX 請求
            fetch(`/calendar-data?year=${year}&month=${month}`)
                .then(response => response.json())
                .then(data => {
                    // 更新日曆 HTML
                    calendarContainer.innerHTML = data.html;
                    
                    // 更新月份顯示
                    if (currentMonthDisplay) {
                        currentMonthDisplay.textContent = data.currentMonth;
                    }
                    
                    // 更新按鈕數據屬性
                    if (prevMonthBtn) {
                        prevMonthBtn.dataset.year = data.prevMonth.year;
                        prevMonthBtn.dataset.month = data.prevMonth.month;
                    }
                    
                    if (nextMonthBtn) {
                        nextMonthBtn.dataset.year = data.nextMonth.year;
                        nextMonthBtn.dataset.month = data.nextMonth.month;
                    }
                    
                    // 更新 URL 而不刷新頁面
                    const url = new URL(window.location);
                    url.searchParams.set('year', year);
                    url.searchParams.set('month', month);
                    window.history.pushState({}, '', url);
                })
                .catch(error => {
                    console.error('載入日曆資料時發生錯誤:', error);
                    calendarContainer.innerHTML = '<div class="alert alert-danger">載入日曆時發生錯誤，請重新整理頁面。</div>';
                });
        }
    }
    
    // 綁定按鈕事件
    if(prevMonthBtn) {
        prevMonthBtn.addEventListener('click', function() {
            loadCalendar(this.dataset.year, this.dataset.month);
        });
    }
    
    if(nextMonthBtn) {
        nextMonthBtn.addEventListener('click', function() {
            loadCalendar(this.dataset.year, this.dataset.month);
        });
    }
    
    if(todayBtn) {
        todayBtn.addEventListener('click', function() {
            loadCalendar(this.dataset.year, this.dataset.month);
        });
    }
});
</script>
@endsection