<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StrTransactions extends Model
{
    protected $table = 'str_transactions';
    public $fillable=[
        "T_ACCOUNT_NUMBER" ,           
  "T_TRANS_NUMBER"  ,            
  "T_LOCATION"       ,           
  "TRANSACTION_DESCRIPTION"  ,  
  "T_TELLER"             ,      
  "T_AUTHORIZED"    ,            
  "T_LATE_DEPOSIT"   ,            
  "T_TRANSMODE_CODE" ,           
  "T_AMOUNT_LOCAL"   ,          
  "T_SOURCE_CLIENT_TYPE"  ,     
  "T_SOURCE_TYPE"     ,         
  "T_SOURCE_FUNDS_CODE" ,        
  "T_SOURCE_CURRENCY_CODE" ,     
  "T_SOURCE_FOREIGN_AMOUNT" ,   
  "T_SOURCE_EXCHANGE_RATE"     ,
  "T_SOURCE_COUNTRY"    ,       
  "T_SOURCE_INSTITUTION_CODE"   ,
  "T_SOURCE_INSTITUTION_NAME" , 
  "T_SOURCE_ACCOUNT_NUMBER"  ,   
  "T_SOURCE_ACCOUNT_NAME"  ,    
  "T_SOURCE_PERSON_FIRST_NAME" ,
  "T_SOURCE_PERSON_LAST_NAME"  ,
  "T_SOURCE_ENTITY_NAME"     ,  
  "T_DEST_CLIENT_TYPE"  ,       
  "T_DEST_TYPE"    ,            
  "T_DEST_FUNDS_CODE"  ,        
  "T_DEST_CURRENCY_CODE"  ,     
  "T_DEST_FOREIGN_AMOUNT"  ,    
  "T_DEST_EXCHANGE_RATE"   ,    
  "T_DEST_COUNTRY"      ,        
  "T_DEST_INSTITUTION_CODE"    , 
  "T_DEST_INSTITUTION_NAME"   , 
  "T_DEST_ACCOUNT_NUMBER"     ,  
  "T_DEST_ACCOUNT_NAME"       , 
  "T_DEST_PERSON_FIRST_NAME"  , 
  "T_DEST_PERSON_LAST_NAME"    ,
  "T_DEST_ENTITY_NAME"     ,    
  "TRAN_TYPE"      ,             
  "CREATED_AT"     ,             
  "T_DATE_POSTING"   ,           
  "T_VALUE_DATE"  ,              
  "T_DATE"    ,                  
  "T_CLIENT_NUMBER" ,            
  "T_GENDER"     ,              
  "T_TITLE"   ,                  
  "T_FIRSTNAME"  ,              
  "T_LASTNAME" ,                 
  "T_DOB"       ,                
  "T_PHONE"      ,                
  "T_ADDRESS"     ,              
  "T_CITY"         ,            
  "T_STATE"         ,           
  "T_IDNUMBER"  ,               
  "T_IDREGDATE"  ,               
  "T_TAXNO"       ,             
  "T_TAXREGDATE"   ,            
  "T_ACCTOPNDATE"   ,            
  "T_BALANCE"        ,          
  "ROW_REF"  ,                   
  "STATUS"    ,                 
  "RULE_ID"    ,                
  "REVIEWER"    ,               
  "download_link"    
    ];

    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->fillable = array_map('strtolower', $this->fillable);
    }
}
