@extends('layouts.admin', ['title' => 'AarogyaCare BioScan Command'])

@section('content')
<div class="bio-dashboard">
    <section class="bio-top">
        <div>
            <span class="bio-kicker"><i class="fa-solid fa-satellite-dish"></i> Live medical data visualization</span>
            <h1>AarogyaCare BioScan Command Board</h1>
            <p>Real-time hospital indicators, patient flow, bed status, and clinical intelligence in one control room view.</p>
        </div>
        <div class="bio-clock"><i class="fa-regular fa-clock"></i><strong>{{ now()->format('H:i') }}</strong><span>IST</span></div>
    </section>

    <section class="bio-grid">
        <aside class="bio-stack">
            <article class="bio-panel bio-score">
                <div class="score-line"><i class="fa-solid fa-person"></i><div><strong>{{ number_format(($metrics['total_patients'] ?? 0) + 102.67, 2) }}</strong><span>Human comprehensive index</span></div></div>
                <div class="bio-mini-grid">
                    <div><b>{{ $metrics['total_patients'] ?? 0 }}</b><span>Total patients</span></div>
                    <div><b>{{ $metrics['today_appointments'] ?? 0 }}</b><span>Today appointments</span></div>
                </div>
                <div class="vital-row"><b>85</b><span>normal HR</span><div class="signal signal-green"></div></div>
                <div class="vital-row"><b>76</b><span>respiration</span><div class="signal signal-orange"></div></div>
                <div class="vital-row"><b>25</b><span>neural load</span><div class="signal signal-yellow"></div></div>
            </article>

            <article class="bio-panel">
                <div class="panel-title"><h2>Operational Queue</h2><span>Live</span></div>
                <div class="queue-list">
                    <div><span>Pending reviews</span><b>{{ $metrics['pending_appointments'] ?? 0 }}</b></div>
                    <div><span>Active doctors</span><b>{{ $metrics['total_doctors'] ?? 0 }}</b></div>
                    <div><span>Departments</span><b>{{ $metrics['total_departments'] ?? 0 }}</b></div>
                    <div><span>Total revenue</span><b>${{ number_format($metrics['total_revenue'] ?? 0, 0) }}</b></div>
                </div>
            </article>
        </aside>

        <section class="bio-panel scan-panel">
            <div class="scan-tags">
                <span>Cell status: clear</span>
                <span>Blood flow: stable</span>
                <span>AI triage: online</span>
            </div>
            <div class="human-scan" aria-label="Patient body scan visualization">
                <div class="scan-line"></div>
                <div class="head"></div><div class="torso"></div><div class="pelvis"></div>
                <div class="arm left"></div><div class="arm right"></div>
                <div class="leg left"></div><div class="leg right"></div>
                <div class="spine"></div><div class="hotspot"></div><div class="platform"></div>
            </div>
        </section>

        <aside class="bio-stack">
            <article class="bio-panel immune-panel">
                <div class="score-line"><i class="fa-solid fa-shield-virus"></i><div><strong>127.39</strong><span>Clinical safety composite</span></div></div>
                <div class="organ-grid">
                    <div><i class="fa-solid fa-brain"></i><b>9437</b><span>Neuro</span></div>
                    <div><i class="fa-solid fa-heart-pulse"></i><b>746</b><span>Cardiac</span></div>
                    <div><i class="fa-solid fa-bed-pulse"></i><b>{{ $beds['icu'] ?? 0 }}</b><span>ICU</span></div>
                    <div><i class="fa-solid fa-lungs"></i><b>783</b><span>Resp</span></div>
                </div>
            </article>

            <article class="bio-panel">
                <div class="panel-title"><h2>Bed Allocation Monitor</h2><span>RP-96573</span></div>
                <div class="bars" aria-hidden="true">
                    @foreach([42,61,54,75,48,88,37,66,93,58,72,45,81,64] as $height)
                        <i style="height: {{ $height }}%"></i>
                    @endforeach
                </div>
                <div class="bed-grid">
                    <div><span>Available</span><b>{{ $beds['available'] ?? 0 }}</b></div>
                    <div><span>Occupied</span><b>{{ $beds['occupied'] ?? 0 }}</b></div>
                    <div><span>ICU Units</span><b>{{ $beds['icu'] ?? 0 }}</b></div>
                    <div><span>Emergency</span><b>{{ $beds['emergency'] ?? 0 }}</b></div>
                </div>
            </article>

            <article class="bio-panel quick-panel">
                <a href="{{ route('admin.settings') }}" class="bio-action"><i class="fa-solid fa-cog"></i> Global Configurations</a>
                <a href="{{ route('admin.system-health') }}" class="bio-action"><i class="fa-solid fa-server"></i> System Health Log</a>
            </article>
        </aside>
    </section>
</div>

<style>
.portal-content{max-width:none!important;padding:22px!important;background:#050b0f}.portal-topbar{background:#071117!important;border-bottom-color:rgba(32,217,255,.2)!important}.bio-dashboard{font-family:Inter,system-ui,sans-serif;color:#effcff;background:radial-gradient(circle at 50% 38%,rgba(32,217,255,.14),transparent 38%),linear-gradient(135deg,#03080a,#081419);border-radius:22px;padding:22px;box-shadow:inset 0 0 80px rgba(32,217,255,.04)}.bio-top{display:flex;justify-content:space-between;gap:18px;align-items:flex-start;margin-bottom:18px}.bio-kicker{display:inline-flex;gap:8px;align-items:center;color:#43ff83;font-weight:900;text-transform:uppercase;font-size:12px}.bio-top h1{margin:10px 0 8px;color:#fff;font-size:clamp(26px,4vw,42px);letter-spacing:.01em}.bio-top p{margin:0;color:#82a8b6;max-width:760px}.bio-clock{display:flex;align-items:center;gap:9px;padding:12px 16px;border:1px solid rgba(64,220,255,.28);border-radius:999px;background:rgba(255,255,255,.04);color:#dffbff}.bio-clock strong{font-size:22px}.bio-grid{display:grid;grid-template-columns:minmax(260px,1fr) minmax(360px,560px) minmax(260px,1fr);gap:18px}.bio-stack{display:grid;gap:18px}.bio-panel{position:relative;overflow:hidden;border:1px solid rgba(64,220,255,.24);border-radius:18px;background:linear-gradient(180deg,rgba(13,34,43,.86),rgba(5,15,20,.78));padding:18px;box-shadow:0 0 45px rgba(32,217,255,.1),inset 0 0 30px rgba(32,217,255,.03)}.bio-panel:before{content:"";position:absolute;inset:0;background:linear-gradient(90deg,transparent,rgba(32,217,255,.08),transparent);transform:translateX(-130%);animation:bioSweep 6s linear infinite;pointer-events:none}@keyframes bioSweep{to{transform:translateX(130%)}}.score-line{display:grid;grid-template-columns:auto 1fr;gap:14px;align-items:center}.score-line i{font-size:48px;color:#43ff83}.score-line strong{display:block;color:#43ff83;font-size:clamp(34px,5vw,56px);line-height:.92;text-shadow:0 0 18px rgba(67,255,131,.35)}.immune-panel .score-line strong{color:#fff}.score-line span,.queue-list span,.bed-grid span{color:#82a8b6;font-weight:800}.bio-mini-grid,.bed-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:18px}.bio-mini-grid div,.bed-grid div,.organ-grid div{padding:12px;border:1px solid rgba(255,255,255,.08);border-radius:12px;background:rgba(255,255,255,.035)}.bio-mini-grid b,.bed-grid b{display:block;color:#fff;font-size:22px}.vital-row{display:grid;grid-template-columns:54px 90px 1fr;gap:10px;align-items:center;margin-top:14px}.vital-row b{font-size:28px;color:#43ff83}.vital-row:nth-of-type(2) b{color:#ff9f3f}.vital-row:nth-of-type(3) b{color:#ffe45c}.signal{height:42px;border-radius:8px;border:1px solid rgba(255,255,255,.08);background:linear-gradient(90deg,transparent 0 12%,rgba(67,255,131,.28) 12% 13%,transparent 13% 29%,rgba(67,255,131,.65) 29% 30%,transparent 30% 54%,rgba(67,255,131,.28) 54% 55%,transparent 55%),repeating-linear-gradient(0deg,transparent 0 10px,rgba(255,255,255,.04) 11px),repeating-linear-gradient(90deg,transparent 0 18px,rgba(255,255,255,.04) 19px)}.signal-orange{filter:hue-rotate(235deg)}.signal-yellow{filter:hue-rotate(170deg)}.panel-title{display:flex;justify-content:space-between;gap:14px;align-items:center;margin-bottom:14px}.panel-title h2{margin:0;color:#fff;font-size:18px}.panel-title span{color:#43ff83;font-weight:900}.queue-list{display:grid;gap:10px}.queue-list div{display:flex;justify-content:space-between;gap:12px;padding:12px;border:1px solid rgba(255,255,255,.08);border-radius:10px;background:rgba(255,255,255,.04)}.queue-list b{color:#43ff83}.scan-panel{display:grid;place-items:center;min-height:700px;background:radial-gradient(circle at center,rgba(30,217,255,.18),transparent 48%),linear-gradient(180deg,rgba(8,22,28,.9),rgba(3,8,12,.92))}.scan-tags{position:absolute;top:20px;left:18px;display:grid;gap:8px;z-index:2}.scan-tags span{padding:7px 10px;border:1px solid #43ff83;background:rgba(0,0,0,.42);color:#dfffe9;border-radius:5px;font-size:12px;font-weight:900}.human-scan{position:relative;width:min(360px,78vw);height:620px;filter:drop-shadow(0 0 30px rgba(32,217,255,.58))}.head,.torso,.pelvis,.arm,.leg{position:absolute;border:2px solid rgba(129,232,255,.9);background:rgba(57,184,255,.14);box-shadow:inset 0 0 28px rgba(150,240,255,.32),0 0 24px rgba(32,217,255,.2)}.head{left:50%;top:12px;width:86px;height:96px;margin-left:-43px;border-radius:50% 50% 44% 44%}.torso{left:50%;top:116px;width:142px;height:215px;margin-left:-71px;border-radius:46% 46% 34% 34%;clip-path:polygon(24% 0,76% 0,100% 38%,78% 100%,22% 100%,0 38%)}.pelvis{left:50%;top:322px;width:116px;height:92px;margin-left:-58px;border-radius:45%}.arm{top:138px;width:48px;height:245px;border-radius:999px}.arm.left{left:58px;transform:rotate(16deg)}.arm.right{right:58px;transform:rotate(-16deg)}.leg{top:398px;width:54px;height:205px;border-radius:999px}.leg.left{left:118px;transform:rotate(4deg)}.leg.right{right:118px;transform:rotate(-4deg)}.spine{position:absolute;left:50%;top:104px;width:8px;height:280px;margin-left:-4px;border-radius:999px;background:linear-gradient(#20d9ff,rgba(255,255,255,.3));box-shadow:0 0 18px #20d9ff}.hotspot{position:absolute;left:50%;top:136px;width:28px;height:28px;margin-left:-14px;border-radius:50%;background:#ff5a28;box-shadow:0 0 30px #ff5a28,0 0 70px #ffb23d}.platform{position:absolute;left:50%;bottom:0;width:310px;height:88px;margin-left:-155px;border:2px solid #20d9ff;border-radius:50%;box-shadow:0 0 36px rgba(32,217,255,.55),inset 0 0 28px rgba(32,217,255,.2)}.scan-line{position:absolute;inset:0;background:linear-gradient(transparent 0 48%,rgba(67,255,131,.2) 49%,transparent 50%);animation:scanMove 3.8s linear infinite}@keyframes scanMove{from{transform:translateY(-44%)}to{transform:translateY(44%)}}.organ-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-top:18px}.organ-grid div{text-align:center}.organ-grid i{display:grid;place-items:center;margin:0 auto 8px;width:40px;height:40px;border:1px solid #43ff83;border-radius:50%;color:#43ff83}.organ-grid b{display:block;color:#fff}.organ-grid span{color:#82a8b6;font-size:11px}.bars{display:flex;align-items:end;gap:7px;height:138px}.bars i{flex:1;border-radius:3px 3px 0 0;background:linear-gradient(#20d9ff,#0c6078);box-shadow:0 0 12px rgba(32,217,255,.28)}.bio-action{display:flex;align-items:center;gap:10px;padding:13px 14px;border:1px solid rgba(64,220,255,.24);border-radius:999px;background:rgba(255,255,255,.05);color:#dffbff;text-decoration:none;font-weight:900}.quick-panel{display:grid;gap:12px}@media(max-width:1180px){.bio-grid{grid-template-columns:1fr}.bio-stack{grid-template-columns:repeat(2,1fr)}.scan-panel{min-height:650px}}@media(max-width:760px){.bio-dashboard{padding:14px}.bio-top{flex-direction:column}.bio-stack{grid-template-columns:1fr}.bio-panel{padding:14px}.organ-grid{grid-template-columns:repeat(2,1fr)}.human-scan{height:560px;transform:scale(.86)}.scan-panel{min-height:590px}.vital-row{grid-template-columns:48px 1fr}.vital-row span{display:none}}
</style>
@endsection