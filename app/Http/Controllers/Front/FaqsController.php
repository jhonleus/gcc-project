<?php
	namespace App\Http\Controllers\Front;

	use App\MaintenanceFaqs;
	use App\Http\Controllers\Controller;

	use Illuminate\Http\Request;

	class FaqsController extends Controller {
		/*faq page*/
	    public function index() {
	    	/*get all the list of faqs*/
	        $faqs = MaintenanceFaqs::all();
	          
	        return view('front.faqs', compact('faqs'));
	    }
	}
?>
