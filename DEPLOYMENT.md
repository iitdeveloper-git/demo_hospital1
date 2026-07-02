# Production Deployment Guidelines

Instructions to deploy AarogyaCare onto AWS, Azure, DigitalOcean or custom VPS nodes.

## AWS Deployment Configuration (Recommended)
1. **EC2 Application Servers:** Deploy the production Docker container stack using Amazon ECS (Elastic Container Service) or directly via Docker Compose on EC2 instances.
2. **RDS Database:** Run a multi-AZ MySQL engine (version 8.0+) on Amazon RDS. Update database credentials in the application environment variables.
3. **Elasticache Redis:** Deploy an Amazon ElastiCache Redis cluster to serve as cache driver and session/queue runner.
4. **S3 Storage:** Configure Laravel storage disk using the `s3` adapter pointing to your Amazon S3 buckets for media library storage.

## Zero-Downtime Rollback Strategy
* Run blue-green deployments via AWS Route53 weightage shifts or local Docker Nginx port-swaps.
