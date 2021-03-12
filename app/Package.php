<?php

namespace App;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
	protected $table ='packages';
	protected $guarded=[];

	public function image()
	{
		return $this->hasMany('App\PaksageImage');
	}
   public function mc_price()
	{
		return $this->belongsTo('App\MC','mc_id','id');
	}
	public function mc()
	{
		return $this->mc_price();
	}
	public function main_img()
	{
        return $this->image()->where('main_img','=', 1);
    }

	public function attibute()
	{
		return $this->hasMany('App\Attibute');
	}

	public function related()
	{
		return $this->hasMany('App\Related_product');
	}

	public function ticket()
	{
		return $this->hasMany('App\Ticket','product_id');
	}

	public function total_tickets_count ()
	{
	    return $this->mc->max_tickets;
	}

	public function perc_of_tickets_sold ()
	{
	    return ceil(($this->purchased_tickets_count ()/$this->total_tickets_count())*100);
	}

	public function perc_of_dummy_tickets_sold ()
	{
	    return ceil(($this->dummy_tickets_count ()/$this->total_tickets_count())*100);
	}

	public function purchased_tickets_count ()
	{
	    return DB::table('tickets')->where('mc_id', $this->mc->id)->where('status', '=', '1')->count();
	}

	public function dummy_tickets_count ()
	{
	    //return $this->ticket()->where('dummy_sold', '=', '1')->count();
	    //return $this->ticket()->where('mc_id', $this->mc->id)->where('dummy_sold', '=', '1')->count();
	    //return $this->mc->ticket()->where('dummy_sold', '=', '1')->count();

	    return DB::table('tickets')->where('mc_id', $this->mc->id)->where('dummy_sold', '1')->count();
	}

	public function sold_or_cart_added_tickets_list ()
	{
	    return $this->ticket()->whereIn('status', [1,2])->pluck('code')->toArray();
	}

	public function dummy_ticket_num_list ()
	{
	    return $this->ticket()->where('dummy_sold', '=', '1')->get();
	}

	public function purchase_dummy_tickets ()
	{

	    $ticket_num_list = range(1, $this->total_tickets_count());
	    $na_tickets_list_num_list = $this->sold_or_cart_added_tickets_list();
	    $available_tickets_num_list = array_diff($ticket_num_list, $na_tickets_list_num_list);

	    $ten_perc_count = ceil(0.10 * count($available_tickets_num_list));

	    $random_ticket_num_list = array_rand($available_tickets_num_list, $ten_perc_count);

    // dd($ticket_num_list[$random_ticket_num_list]);

//	    $dummy_tickets = new Ticket();
//
//	    $data = [];

	   // foreach ($random_ticket_num_list as $key => $ticket_num)
	   // {
	   //     $data[] = array('user_id' => 0,
	   //                     'product_id'=> $this->id,
	   //                     'mc_id' => $this->mc->id,
	   //                     'code' => $ticket_num,
	   //                     'date_purchased' => date('Y-m-d H:i:s'),
	   //                     'paid_price' => 0,
	   //                     'discount' => 0,
	   //                     'status' => 0,
	   //                     'dummy_sold' => 1,
	   //                     'created_at' => date('Y-m-d H:i:s'));
	   // }
// dd($available_tickets_num_list);
        if(is_array($random_ticket_num_list))
        {
           Ticket::where('mc_id', $this->mc->id)->whereIn('code', $random_ticket_num_list)->update(['dummy_sold' => 1]); 
        }else{
            $tick_numm = $ticket_num_list[$random_ticket_num_list];
            Ticket::where('mc_id', $this->mc->id)->where('code', $tick_numm)->update(['dummy_sold' => 1]);
        }
	    

	   // echo "<pre>";
	   // print_r($data);
	   // exit;

        //Ticket::insert($data);


	    //return $random_ticket_num_list;
	}

	public function undo_dummy_ticket_purchase ()
	{
	    //return $this->ticket()->where('mc_id', '=', $this->mc->id)->where('dummy_sold', '=', 1)->update(['dummy_sold' => 0]);
	    DB::table('tickets')->where('mc_id', $this->mc->id)->where('dummy_sold', '=', '1')->update(['dummy_sold' => 0]);
	}

	public function email_schedule ()
	{
        return $this->hasOne('App\CompetitionEmailSchedule');
	}

	public function urlCategory()
	{
        return $this->belongsTo('App\UrlCategory','url_category');
	}


}
