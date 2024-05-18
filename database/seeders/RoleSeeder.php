<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $purchase = Role::create(['name' => 'Purchase']);
        $productManager = Role::create(['name' => 'Product Manager']);
        $storekeeper = Role::create(['name' => 'Store Keeper']);
        $sfstorekeeper = Role::create(['name' => 'SF Store Keeper']);
        $fgstorekeeper = Role::create(['name' => 'FG Store Keeper']);
        $salesManager = Role::create(['name' => 'Sales Manager']);
        $iqc = Role::create(['name' => 'Incoming QC']);
        $fqc = Role::create(['name' => 'Final QC']);
        $qc_manager = Role::create(['name' => 'Quality Manager']);
        $scrap_incharge = Role::create(['name' => 'Scrap Incharge']);
        $user = Role::create(['name' => 'User']);

        $admin->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
            'create-product',
            'edit-product',
            'delete-product',
            'create-department',
            'edit-department'
        ]);

        $productManager->givePermissionTo([
            'create-product',
            'edit-product',
            'delete-product'
        ]);

        $purchase->givePermissionTo([
            'create-rm',
            'edit-rm',
            'create-rm_category',
            'edit-rm_category',
            'create-supplier',
            'edit-supplier',
            'create-supplier_products',
            'edit-supplier_products',
            'create-po',
            'create-po_correction_request',
            'create-po_correction_approval',
            'create-po_correction'
        ]);

        $storekeeper->givePermissionTo([
            'create-rack_category',
            'edit-rack_category',
            'create-rack_master',
            'edit-rack_master',
            'create-rm_inward',
            'create-rm_issuance',
            'create-return_rmissuance',
            'create-rc_dc_issuance',
        ]);

        $sfstorekeeper->givePermissionTo([
            'create-sf_receive',
            'create-sf_issuance'
        ]);

        $fgstorekeeper->givePermissionTo([
            'create-fg_receive'
        ]);

        $salesManager->givePermissionTo([
            'create-customer',
            'edit-customer',
            'create-customer_products',
            'edit-customer_products',
            'create-customer_po_master',
            'edit-customer_po_master',
            'create-customer_po_rate_revise',
            'edit-customer_po_rate_revise',
            'create-invoice',
            'create-invoice_correction_request',
            'create-invoice_correction_approval',
            'create-invoice_correction',
            'create-supplymentary_invoice'
        ]);

        $iqc->givePermissionTo([
            'create-rm_iqc'
        ]);

        $fqc->givePermissionTo([
            'create-fqc_approval'
        ]);
        $qc_manager->givePermissionTo([
            'create-fqc_approval',
            'create-pts_fqc_approval',
            'create-qc_rework',
            'create-qc_rejection',
            'create-rm_iqc'
        ]);
        $scrap_incharge->givePermissionTo([
            'create-qc_rejection'
        ]);
        $user->givePermissionTo([
            'create-product',
            'edit-product',
            'delete-product'
        ]);

    }
}
