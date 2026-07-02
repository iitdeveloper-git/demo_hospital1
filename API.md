# AarogyaCare API Integration Specifications

AarogyaCare provides versions API endpoints ready to be integrated with mobile apps (Flutter, iOS, Android) and external LIMS interfaces.

## Endpoint References

### 1. CDSS Checkers
* `POST /api/v1/ai/triage-check` (Symptom checking variables analysis).
* `POST /api/v1/ai/drug-interaction` (Scans contraindications and warnings).

### 2. Business Intelligence & Metrics
* `GET /api/v1/analytics/snapshots` (Retrieves revenue/admissions timelines).

### 3. CMS Public Resources
* `GET /api/v1/cms/pages/{slug}` (Layout structure fetch).
* `GET /api/v1/cms/blogs` (Fetch list of published posts).
