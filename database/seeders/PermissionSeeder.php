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
            'create-role',
            'edit-role',
            'delete-role',
            'create-user',
            'edit-user',
            'delete-user',
            'create-product',
            'edit-product',
            'delete-product',
            'create-qrlock',
            'edit-qrlock',
            'create-department',
            'edit-department',
            'create-rm',
            'edit-rm',
            'create-rm_category',
            'edit-rm_category',
            'create-rack_category',
            'edit-rack_category',
            'create-rack_master',
            'edit-rack_master',
            'create-supplier',
            'edit-supplier',
            'create-supplier_products',
            'edit-supplier_products',
            'create-po',
            'create-po_correction_request',
            'create-po_correction_approval',
            'create-po_correction',
            'create-rm_inward',
            'create-rm_iqc',
            'create-rm_issuance',
            'create-return_rmissuance',
            'create-rc_dc_issuance',
            'create-sf_receive',
            'create-sf_issuance',
            'create-os_issuance',
            'create-os_receive',
            'create-os_dcissuance',
            'create-fg_receive',
            'create-fqc_approval',
            'create-pts_fqc_approval',
            'create-qc_rework',
            'create-qc_rejection',
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
            'create-supplymentary_invoice',
            'create-dc_issuance',
            'edit-dc_issuance',
            'create-pts_dc_muliti_inward',
            'create-cle_dc_muliti_inward',
            'create-pts_dc_inward',
            'create-cle_dc_inward',
            'create-pts_production_receive',
            'create-cle_issue',
            'create-cle_production_receive',
            'create-pts_dc_issuance',
            'create-u1_dc_multi_receive',
            'create-sc_virtual_dcreceive',
            'create-orderbook',
            'edit-orderbook',
         ];

          // Looping and Inserting Array's Permissions into Permission Table
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
          }
    }
}
