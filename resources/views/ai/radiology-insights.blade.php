@extends('layouts.ai', ['title' => 'Radiology AI Diagnostic Pipeline'])

@section('content')
<div class="glass-panel">
    <h2>Radiology AI Model Orchestrator</h2>
    <p style="color:var(--text-muted); font-size:13.5px; margin-bottom:24px;">Pipeline architecture and image classification workflow for X-Ray, MRI, CT, and Ultrasound modalities.</p>

    <!-- Visual Architecture Flowchart -->
    <div style="background:var(--bg-canvas); border:1px solid var(--glass-border); padding:32px; border-radius:16px; margin-bottom:32px; text-align:center;">
        <h3>Active Inference Pipeline Flow</h3>
        
        <div style="display:flex; justify-content:center; align-items:center; gap:20px; flex-wrap:wrap; margin-top:24px;">
            <div style="background:var(--bg-card); border:1px solid #0f6fff; padding:16px; border-radius:12px; min-width:140px;">
                <i class="fa-solid fa-cloud-arrow-up" style="font-size:24px; color:#0f6fff; margin-bottom:8px;"></i>
                <strong style="display:block; font-size:13px;">DICOM UPLOAD</strong>
                <small style="font-size:10px; color:var(--text-muted);">PACS Server Webhook</small>
            </div>
            
            <i class="fa-solid fa-arrow-right" style="color:var(--text-muted);"></i>
            
            <div style="background:var(--bg-card); border:1px solid var(--glass-border); padding:16px; border-radius:12px; min-width:140px;">
                <i class="fa-solid fa-compress" style="font-size:24px; color:#14b8a6; margin-bottom:8px;"></i>
                <strong style="display:block; font-size:13px;">PREPROCESSING</strong>
                <small style="font-size:10px; color:var(--text-muted);">Normalisation & Resize</small>
            </div>

            <i class="fa-solid fa-arrow-right" style="color:var(--text-muted);"></i>

            <div style="background:var(--bg-card); border:1px solid #8b5cf6; padding:16px; border-radius:12px; min-width:140px;">
                <i class="fa-solid fa-network-wired" style="font-size:24px; color:#8b5cf6; margin-bottom:8px;"></i>
                <strong style="display:block; font-size:13px;">CNN INFERENCE</strong>
                <small style="font-size:10px; color:var(--text-muted);">Segmentation Model</small>
            </div>

            <i class="fa-solid fa-arrow-right" style="color:var(--text-muted);"></i>

            <div style="background:var(--bg-card); border:1px solid var(--glass-border); padding:16px; border-radius:12px; min-width:140px;">
                <i class="fa-solid fa-square-check" style="font-size:24px; color:#10b981; margin-bottom:8px;"></i>
                <strong style="display:block; font-size:13px;">REPORT CO-PILOT</strong>
                <small style="font-size:10px; color:var(--text-muted);">Drafting Clinical Findings</small>
            </div>
        </div>
    </div>

    <!-- Active Radiology Queue -->
    <h3>Pending Classification Queue</h3>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Modality</th>
                    <th>Report Ref</th>
                    <th>AI Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $rep)
                    <tr>
                        <td>
                            <strong>{{ $rep->patient->user->name }}</strong>
                            <span style="display:block; font-size:11px; color:var(--text-muted);">{{ $rep->patient->patient_code }}</span>
                        </td>
                        <td>
                            <span class="pill" style="text-transform:uppercase; font-size:10px;">{{ rand(0, 1) ? 'X-RAY (Chest)' : 'MRI (Brain)' }}</span>
                        </td>
                        <td><code>{{ $rep->reported_at }}</code></td>
                        <td>
                            <span class="status-pill" style="background:rgba(20,184,166,0.1); color:#14b8a6; font-weight:700;">MODEL READY</span>
                        </td>
                        <td>
                            <button class="btn btn-soft" style="min-height:32px; font-size:12px;" onclick="alert('Running segmentation classifier inference on PACS storage target...')">
                                <i class="fa-solid fa-play"></i> Trigger Inference
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="empty-state">No radiology requests in queue.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
