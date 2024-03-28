# Apartment Complex Database

## Overview

The Apartment Complex Database is designed to manage and organize data for an apartment complex, including tenant information, leases, amenities, and maintenance jobs. This comprehensive system allows for efficient tracking of apartments, tenants, and financials, as well as scheduling and completing maintenance tasks.

## Features

- **Tenant Management**: Track tenant details, lease agreements, and payment histories.
- **Lease Administration**: Manage lease terms, expirations, and renewals.
- **Amenity Tracking**: Record and monitor the use of amenities by tenants.
- **Maintenance Scheduling**: Organize and oversee maintenance projects and tasks.

## Database Schema

### Tables

- **Apartment**: Stores details about the apartments.
- **Tenant**: Contains tenant information.
- **Lease**: Records lease agreements.
- **Amenities**: Lists available amenities.
- **Amenity_Used**: Tracks the usage of amenities by tenants.
- **Maintenance_Job**: Details maintenance tasks and projects.

### Relationships

- Tenants sign leases, which are linked to apartments.
- Maintenance jobs are assigned to specific apartments.
- Tenants use amenities, recorded in the Amenity_Used table.

## Functional Dependencies

- Apartment attributes are determined by the apartment number.
- Tenant information is dependent on the tenant ID.
- Lease details are linked to the lease ID.

## Entity-Relationship Diagram

- Illustrates the relationships between entities like apartments, tenants, leases, and amenities.

## Query Examples

1. **Tenant Contact List**: Generate a list of tenants with their contact information, sorted by apartment number.
2. **Late Rent Tracking**: Identify tenants with late rent payments, including lease terms and contact details.
3. **Lease Expiration Notices**: List leases expiring in the next three months to prepare for renewals or vacancies.
4. **Financial Reporting**: Calculate profits from extra services and supplies over the past year, broken down by month.

## System Access

- **Web Interface**: Access the database through the provided web interface at `https://csci3287.cse.ucdenver.edu/~hokr/db/`.
- **Server Details**: Hosted on `csci3287.cse.ucdenver.edu` with nightly backups.

## Security

- Admin login credentials are provided for database management.
