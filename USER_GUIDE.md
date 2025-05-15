# Input Penduduk - User Guide

## Introduction

Welcome to the User Guide for the Input Penduduk application. This guide provides comprehensive instructions for using the application to manage population data effectively and securely.

## Table of Contents

1. [Getting Started](#getting-started)
2. [Initial Setup](#initial-setup)
3. [Dashboard Navigation](#dashboard-navigation)
4. [Managing Population Data](#managing-population-data)
5. [Searching and Filtering](#searching-and-filtering)
6. [Data Export](#data-export)
7. [Account Management](#account-management)
8. [Troubleshooting](#troubleshooting)

## Getting Started

### Accessing the Application

1. Open your web browser and navigate to the application URL provided by your administrator.
2. You will be presented with a login screen.
3. Enter your username and password.
4. Click the "Login" button.

> **Note**: For security reasons, the application will automatically log you out after 60 minutes of inactivity.

### First-Time Login

If this is your first time logging in, you may be prompted to:
- Change your initial password
- Set up two-factor authentication (if enabled)
- Review and accept the application's terms of use

## Initial Setup

### Database Initialization

For system administrators setting up the application for the first time:

1. Ensure the database connection is properly configured in the `.env` file
2. Run database migrations to create the necessary tables:
   ```
   php artisan migrate
   ```
3. Seed the database with initial reference data and operator accounts:
   ```
   php artisan db:seed
   ```

### Default Operator Accounts

The seeding process creates multiple operator accounts (operator1 through operator10) with randomly generated passwords. These credentials are saved to:
```
storage/app/operator-credentials.txt
```

For security reasons, you should:
1. Access this file after initial setup
2. Distribute the credentials to your operators securely
3. Require operators to change their passwords upon first login
4. Delete the credentials file once all operators have been set up

### Reference Data

The application comes pre-loaded with standard reference data including:
- Religions (Islam, Kristen, Katolik, etc.)
- Education levels
- Occupations
- Marital statuses
- Family relationship types
- And other necessary lookup values

## Dashboard Navigation

After logging in, you will be directed to the dashboard, which provides:

- Overview statistics of your population data
- Quick access buttons to common tasks
- Recent activity log
- System notifications

The main navigation menu is located on the left side of the screen and includes:

- **Home**: Returns to the dashboard
- **Penduduk**: Population data management
- **Export**: Data export options
- **Reports**: Reporting functions
- **Account**: User account settings
- **Logout**: Securely exit the application

## Managing Population Data

### Viewing Population Data

1. Click **Penduduk** in the main navigation menu.
2. The system displays a paginated list of population records.
3. By default, 10 records are shown per page. You can adjust this using the "Items per page" dropdown at the bottom of the list.

### Adding a New Family

1. From the Penduduk page, click the "Add New Family" button.
2. Fill in the required family information:
   - Family Card Number (No. KK)
   - Address details
   - Family members information
3. For each family member, provide:
   - NIK (National ID Number)
   - Name
   - Gender
   - Place and date of birth
   - Religion
   - Education
   - Occupation
   - Marital status
   - Family relationship status
   - Other relevant information
4. Click "Save" to store the data.

### Editing Existing Records

1. From the Penduduk list, locate the record you wish to edit.
2. Click the "Edit" button (pencil icon) next to the record.
3. Make the necessary changes to the data.
4. Click "Update" to save your changes.

### Deleting Records

1. From the Penduduk list, locate the record you wish to delete.
2. Click the "Delete" button (trash icon) next to the record.
3. Confirm the deletion when prompted.

> **Note**: Deleted records are not permanently removed but are marked as deleted (soft delete). Administrators can restore these records if needed.

## Searching and Filtering

### Basic Search

1. On the Penduduk page, locate the search box at the top of the list.
2. Enter a search term (name, NIK, or Family Card Number).
3. Press Enter or click the search icon.
4. The system will display all records matching your search criteria.
5. Search is optimized with database indexes (as of May 15, 2025) for fast performance even with large datasets.

### Advanced Filtering

1. Click the "Filter" button above the Penduduk list.
2. Select filtering criteria:
   - Region/Dusun (optimized with database indexes)
   - Age range
   - Gender
   - Marital status
   - Other available filters
3. Click "Apply Filter" to filter the records.
4. To clear filters, click "Reset Filters".
5. Filtered results maintain pagination and can be exported directly.

### Pagination

- Navigate between pages using the pagination controls at the bottom of the list.
- Adjust the number of items per page using the dropdown menu.
- Default pagination shows 10 items per page, but can be adjusted to 25, 50, or 100 items.

## Data Export

### Exporting to Excel

1. From the Penduduk list, apply any desired filters to target specific data.
2. Click the "Export" button above the list.
3. Select "Excel" as the export format.
4. The system will generate and download an Excel file containing the current filtered data.
5. Exports are handled by the ExportController (updated May 15, 2025) which preserves all applied filters.
6. The filename will include the date and filter information if any filters are applied.

### Customizing Export

1. Click the "Export" button.
2. Select "Customize Export".
3. Choose which fields to include in the export.
4. Select the export format.
5. Click "Generate Export".

> **Note**: All data exports are logged in the system's audit log for security and compliance purposes.

## Account Management

### Changing Password

1. Click on your username in the top-right corner.
2. Select "Account Settings".
3. Click "Change Password".
4. Enter your current password.
5. Enter and confirm your new password.
6. Click "Update Password".

### Profile Settings

1. Go to Account Settings.
2. Update your profile information as needed.
3. Click "Save Changes".

## Troubleshooting

### Common Issues

#### Login Problems
- Ensure your username and password are correct.
- Check that Caps Lock is not enabled.
- If you've forgotten your password, use the "Forgot Password" link on the login page.

#### Data Not Saving
- Ensure all required fields are completed.
- Check your internet connection.
- Try refreshing the page and attempting again.

#### Export Problems
- Ensure you have permission to export data.
- Try exporting a smaller dataset by applying more filters.

### Getting Help

If you encounter issues not covered in this guide:

1. Check the in-application help resources by clicking the "Help" icon.
2. Contact your system administrator.
3. Submit a support ticket through the appropriate channels.

---

*Last updated: May 15, 2025*
