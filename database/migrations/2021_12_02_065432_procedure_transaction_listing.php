<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProcedureTransactionListing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $stored_procedure = "
            DROP PROCEDURE IF EXISTS `transaction_listing`;

            CREATE PROCEDURE transaction_listing()
                BEGIN
                    SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
                    SET SESSION sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
                    DROP TEMPORARY TABLE IF EXISTS  _invoice;
                    CREATE TEMPORARY TABLE _invoice 
                    SELECT 
                        invoice.`id`,
                        invoice.`invoice_number`,
                        invoice.`order_date`,
                        purchaser.`id` AS 'purchaser_id',
                        CONCAT(purchaser.`first_name`,' ', purchaser.`last_name`) AS 'purchaser',
                        distributor.id AS 'distributor_id',
                        CONCAT(distributor.`first_name`,' ', distributor.`last_name`) AS 'distributor'
                    FROM orders invoice
                    INNER JOIN users purchaser ON purchaser.`id` = invoice.`purchaser_id`
                    INNER JOIN users distributor ON distributor.`id` = purchaser.`referred_by` 
                    LIMIT 50
                    ;
            
                    DROP TABLE IF EXISTS _referrals;
                    CREATE TEMPORARY TABLE _referrals 
                    SELECT DISTINCT referred_by AS 'distributor_id', id, enrolled_date FROM users 
                        WHERE referred_by IN (SELECT DISTINCT distributor_id FROM _invoice)
                    ;
            
                    DROP TABLE IF EXISTS _customers;
                    CREATE TEMPORARY TABLE _customers 	
                    SELECT 
                        categories.`user_id` AS 'purchaser_id',
                        categories.`category_id` AS 'is_customer'
                    FROM _invoice
                    INNER JOIN `user_category` categories ON categories.`user_id` = _invoice.purchaser_id
                    WHERE categories.`category_id` = 2
                    ;
            
            
                    DROP TABLE IF EXISTS _order_details;
                    CREATE TEMPORARY TABLE _order_details 	
                    SELECT 
                        order_items.order_id AS 'invoice_id',
                        order_items.`qantity`*products.`price` AS 'amount'
                    FROM `order_items` 
                    INNER JOIN products ON products.`id` = order_items.`product_id`
                    WHERE order_id IN (SELECT id FROM _invoice);
            
            
                    DROP TABLE IF EXISTS _uncalculated;
                    CREATE TEMPORARY TABLE _uncalculated 	
                    SELECT 
                        _invoice.id AS 'invoice',
                        _invoice.purchaser,
                        _invoice.distributor,
                        SUM(IF(_referrals.enrolled_date <= _invoice.order_date,1,0)) AS 'referred',
                        _invoice.order_date,
                        _order_details.amount AS 'order_total',
                        _customers.is_customer 
                        
                    FROM _invoice 
                    INNER JOIN _order_details ON _order_details.invoice_id = _invoice.id
                    LEFT JOIN _referrals ON _referrals.distributor_id = _invoice.distributor_id
                    LEFT JOIN _customers ON _customers.purchaser_id = _invoice.purchaser_id
                    GROUP BY _invoice.id
                    ;
            
            
                    SELECT 
                        _uncalculated.invoice,
                        _uncalculated.purchaser,
                        _uncalculated.distributor,
                        _uncalculated.referred,
                        _uncalculated.order_date,
                        _uncalculated.order_total,
                        IF(_uncalculated.is_customer = 2 , IF(_uncalculated.referred >=31,30, IF(_uncalculated.referred >=21,20,IF(_uncalculated.referred >=11,15, IF(_uncalculated.referred >=5,10, 5 )) )), 0) AS 'percentage',
                        IF(_uncalculated.is_customer = 2 , (IF(_uncalculated.referred >=31,30, IF(_uncalculated.referred >=21,20,IF(_uncalculated.referred >=11,15, IF(_uncalculated.referred >=5,10, 5 )) ))/100 ) * _uncalculated.order_total , 0) AS 'commission'
                        
                    FROM _uncalculated;
            
                END;";

            \DB::unprepared($stored_procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
