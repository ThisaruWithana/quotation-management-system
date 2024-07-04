<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'admin.user.index',
            'admin.user.create',
            'admin.user.edit',
            'admin.user.delete',
            'admin.user.change-status',

            'admin.role.index',
            'admin.role.create',
            'admin.role.edit',
            'admin.role.delete',
            'admin.role.change-status',

            'admin.permission.index',
            'admin.permission.create',
            'admin.permission.edit',
            'admin.permission.delete',
            'admin.permission.change-status',

            'admin.location.index',
            'admin.location.create',
            'admin.location.edit',
            'admin.location.delete',
            'admin.location.change-status',

            'admin.vat.index',
            'admin.vat.create',
            'admin.vat.edit',
            'admin.vat.delete',

            'admin.supplier.index',
            'admin.supplier.create',
            'admin.supplier.edit',
            'admin.supplier.delete',
            'admin.supplier.change-status',
            
            'admin.department.index',
            'admin.department.create',
            'admin.department.edit',
            'admin.department.delete',
            'admin.department.change-status',
            
            'admin.department.sub.index',
            'admin.department.sub.create',
            'admin.department.sub.store',
            'admin.department.sub.edit',
            'admin.department.sub.change-status',
            'admin.department.get-subdepartments-by-departments',
            'admin.department.get-vat-value',
            
            'admin.customer.index',
            'admin.customer.create',
            'admin.customer.edit',
            'admin.customer.delete',
            'admin.customer.change-status',
            'admin.customer.get-details',

            'admin.bundle.index',
            'admin.bundle.create',
            'admin.bundle.edit',
            'admin.bundle.delete',
            'admin.bundle.change-status',
            'admin.bundle.add-items',
            'admin.bundle.update-display-status',
            'admin.bundle.delete-item',
            'admin.bundle.item-update',
            'admin.bundle.get-details',
            'admin.bundle.update-bundle-item-order',
            'admin.bundle.destroy',

            'admin.item',
            'admin.item.create',
            'admin.item.store',
            'admin.item.edit',
            'admin.item.detail',
            'admin.item.change-status',
            'admin.item.download-barcode',
            'admin.item.store-details',
            'admin.item.store-stock-settings',
            'admin.item.store-item-pricing',
            'admin.item.update',
            'admin.item.calculate-margin',
            'admin.item.search',
            'admin.item.update-mandatory-status',
            'admin.item.update-display-status',
            'admin.item.store-sub-items',
            'admin.item.get-sub-items',

            'admin.quotation',
            'admin.quotation.create',
            'admin.quotation.edit',
            'admin.quotation.print',
            'admin.quotation.store',
            'admin.quotation.change-status',
            'admin.quotation.add-items',
            'admin.quotation.update-display-status',
            'admin.quotation.delete-item',
            'admin.quotation.item-update',
            'admin.quotation.update-price-info',
            'admin.quotation.add-bundle',
            'admin.quotation.edit-bundle',
            'admin.quotation.update-quotation-item-order',
            'admin.quotation.destroy',
            
            'admin.opf',
            'admin.opf.print',
            'admin.opf.update',
            'admin.opf.add-items',
            'admin.opf.delete-item',
            'admin.opf.item-update',
            'admin.opf.add-bundle',
            'admin.opf.edit-bundle',

            'admin.po',
            'admin.po.create',
            'admin.po.edit',
            'admin.po.store',
            'admin.po.update',
            'admin.po.change-status',
            'admin.po.add-items',
            'admin.po.delete-item',
            'admin.po.item-update',
            'admin.po.send-order',
            'admin.po.import',

            'admin.deliveries',
            'admin.deliveries.create',
            'admin.deliveries.edit',
            'admin.deliveries.store',
            'admin.deliveries.update',
            'admin.deliveries.change-status',
            'admin.deliveries.add-items',
            'admin.deliveries.delete-item',
            'admin.deliveries.item-update',
            'admin.deliveries.suspend',
            'admin.deliveries.update-stock',

            'admin.report.barcode',
            'admin.report.order-history',
            'admin.report.print-label',

            
            'admin.stock',
            'admin.stock.view',
            'admin.stock.create-adjustment',
            'admin.stock.adjustment',
            'admin.stock.add-items',
            'admin.stock.delete-item',
            'admin.stock.item-update',
            'admin.stock.update-stock',
            'admin.stock.take',
            'admin.stock.create-stock-take',
            'admin.stock.take-edit',
            'admin.stock.take-change-status',
            'admin.stock.store-take',
            'admin.stock.add-stock-take-items',
            'admin.stock.delete-stock-take-item',
            'admin.stock.take-item-update',
            'admin.stock.stock-take-update-stock',

        ];

        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

    }
}
