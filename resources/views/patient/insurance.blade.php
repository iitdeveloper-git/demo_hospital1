@extends('layouts.patient', ['title' => 'Insurance & Coverage'])

@section('content')
<div class="insurance-wrap">
    <div class="insurance-grid">
        <!-- Insurance Card mockup -->
        <div class="panel card-mockup-panel">
            <div class="insurance-card-digital">
                <div class="card-brand">
                    <span><i class="fa-solid fa-shield-heart"></i> MedovaShield</span>
                    <span class="card-chip"><i class="fa-solid fa-microchip"></i></span>
                </div>
                <div class="card-body">
                    <span class="card-label">INSURANCE PROVIDER</span>
                    <h3 class="card-provider">{{ $patient->insurance_provider ?? 'CareShield Gold' }}</h3>
                    
                    <div class="card-meta">
                        <div>
                            <span class="card-label">POLICY NUMBER</span>
                            <span class="card-val">POL-{{ str_pad((string)$patient->id, 8, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div>
                            <span class="card-label">MEMBER CODE</span>
                            <span class="card-val">{{ $patient->patient_code }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <span>STATUS: ACTIVE</span>
                    <span>CO-PAY: $15.00</span>
                </div>
            </div>
        </div>

        <!-- Coverage & Policy details -->
        <div class="panel">
            <div class="panel-header">
                <h2>Policy & Verification Status</h2>
            </div>
            
            <div class="policy-details-list">
                <div class="policy-detail-row">
                    <span class="label">Provider Name</span>
                    <strong>{{ $patient->insurance_provider ?? 'CareShield Gold' }}</strong>
                </div>
                <div class="policy-detail-row">
                    <span class="label">Verification Status</span>
                    <strong class="text-success"><i class="fa-solid fa-circle-check"></i> Verified & Active</strong>
                </div>
                <div class="policy-detail-row">
                    <span class="label">Coverage Scope</span>
                    <strong>OPD Consultations, Pathology Labs, Cardiology Procedures, Inpatient Hospitalization</strong>
                </div>
                <div class="policy-detail-row">
                    <span class="label">Annual Limit</span>
                    <strong>$150,000.00 / Individual</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .insurance-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 32px;
        align-items: start;
    }

    .card-mockup-panel {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 24px !important;
        background-color: var(--bg-card);
    }

    /* Insurance Card Mockup */
    .insurance-card-digital {
        width: 100%;
        max-width: 360px;
        height: 220px;
        background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);
        border-radius: 16px;
        padding: 24px;
        color: #ffffff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.3), 0 8px 10px -6px rgba(15, 23, 42, 0.3);
        font-family: 'Outfit', sans-serif;
        position: relative;
        overflow: hidden;
    }

    .insurance-card-digital::before {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        background: rgba(96, 165, 250, 0.1);
        border-radius: 50%;
        bottom: -50px;
        right: -50px;
        filter: blur(40px);
    }

    .card-brand {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 16px;
        font-weight: 700;
        letter-spacing: -0.01em;
    }

    .card-chip {
        color: #f59e0b;
        font-size: 24px;
    }

    .card-body {
        margin-top: 10px;
    }

    .card-label {
        font-size: 9px;
        color: #93c5fd;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        display: block;
        margin-bottom: 2px;
        font-weight: 600;
    }

    .card-provider {
        font-size: 18px;
        margin: 0 0 16px;
        font-weight: 700;
    }

    .card-meta {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        gap: 16px;
    }

    .card-val {
        font-size: 13px;
        font-weight: 600;
        letter-spacing: 0.05em;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        font-size: 10px;
        color: #93c5fd;
        font-weight: 600;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 12px;
    }

    /* Policy details */
    .policy-details-list {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .policy-detail-row {
        display: flex;
        flex-direction: column;
        gap: 4px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 12px;
    }

    .policy-detail-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .policy-detail-row .label {
        font-size: 11px;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 600;
    }

    .policy-detail-row strong {
        font-size: 14px;
    }

    .text-success {
        color: #10b981;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    @media (max-width: 768px) {
        .insurance-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
