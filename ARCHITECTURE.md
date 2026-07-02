# System Architecture Specifications

AarogyaCare utilizes the robust **Repository + Service pattern** to maintain strict separation of concerns, fulfilling SOLID design principles.

## Structure Layout
* **Models Layer (`app/Models/`):** Contains Eloquent models defining schema validations and relationships.
* **Repositories Layer (`app/Repositories/`):** Encapsulates direct database queries.
* **Services Layer (`app/Services/`):** Handles core business logic (CDSS, Analytics compile, SEO, sitemaps).
* **Controllers Layer (`app/Http/Controllers/`):** Delegates commands between routers and service structures.

## Multi-Tenant Architecture (Future Ready)
* Multi-branch configurations are separated using a `branch_id` scope filter on snapshots and transaction entries.
* Database connections are dynamically switched using custom tenant connection middleware resolvers.
