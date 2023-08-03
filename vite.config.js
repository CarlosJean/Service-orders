import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/azia.css',
                'resources/css/azia.min.css',
                'resources/css/login.css',
                'resources/css/whiteBackgroundColor.css',
                'resources/js/app.js',
                'resources/js/assignTechnician.js',
                'resources/js/azia.js',
                'resources/js/categories.js',
                'resources/js/departments.js',
                'resources/js/employeesList.js',
                'resources/js/inventoryValue.js',
                'resources/js/items.js',
                'resources/js/itemsDispatch.js',
                'resources/js/materialsManagement.js',
                'resources/js/materialsManagementIndex.js',
                'resources/js/purchaseOrders.js',
                'resources/js/purchaseOrdersIndex.js',
                'resources/js/quotes.js',
                'resources/js/quotesIndex.js',
                'resources/js/reports.js',
                'resources/js/roles.js',
                'resources/js/serviceOrders.js',
                'resources/js/services.js',
                'resources/js/suppliers.js',
                'resources/js/technicianOrder.js',
                'resources/js/userTechnician.js',
                'resources/sass/app.scss',
            ],
            refresh: true,
        }),
    ],
});