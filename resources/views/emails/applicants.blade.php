<div style="box-shadow:0 .5rem 1rem rgba(0,0,0,.15)!important;width:100%;border:1px solid rgba(0,0,0,.125);border-radius:10px;">
	<div style="border-radius:10px;background-color: rgba(0, 0, 0, 0.03);text-align:center;">
			<img src="https://globalcareercreation.com/wp-content/uploads/2019/09/header_icon.png" style="width:auto;height: 50px;padding:15px;cursor: pointer;">
		</div>
		<div style="padding:10px 20px 10px 20px;margin-bottom:20px;font-family:arial;font-size:12px;line-height:18px;">
			<p style="margin-block-start:0;margin-block-end:0;">Hi, <b>{{$fullname}}, </b>this is the list of applicant that matched to your job post.</p>

			<br>

			@foreach($users as $user)
			<div style="flex: 0 0 100%;max-width: 100%;">
				<div style="padding: 20px 10px 20px 10px;box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;margin-bottom: 15px;position: relative;display: -ms-flexbox;display: flex;-ms-flex-direction: column;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 1px solid rgba(0,0,0,.125);border-radius: .25rem;">
					<div style="flex: 1 1 auto;margin: 2px 20px 10px 20px;padding: 0;">
						<div style="display: -ms-flexbox;display: flex;-ms-flex-wrap: wrap;flex-wrap: wrap;margin-right: -15px;margin-left: -15px;    box-sizing: border-box;">
							<div style="-ms-flex: 0 0 33.333333%;flex: 0 0 33.333333%;max-width: 33.333333%;position: relative;width: 100%;min-height: 1px;padding-right: 15px;padding-left: 15px;box-sizing: border-box;">
								@foreach($user->documents as $doc)
									@if($doc->filetype==="profile")
									<img src="{{ url($doc->path . $doc->filename)}}" style="width: 100%; height: auto;padding: 10px;">
									@endif	
								@endforeach
							</div>
							<div style="-ms-flex: 0 0 66.666667%;flex: 0 0 66.666667%;max-width: 66.666667%;position: relative;width: 100%;min-height: 1px;padding-right: 15px;padding-left: 15px;box-sizing: border-box;">
								<div style="border-bottom: 1px solid #e6e6e6;">
									<a href="" style="color: #000000;display: inline;font-size: 20px;font-weight: 700;margin-block-end: 0;margin-block-start: 0;text-decoration: none;font-family:Roboto;">
										{{$user->firstName}}  {{$user->lastName}}
									</a>
								</div>
								<label style="color: #000000;margin: 10px 10px 0 10px;display: block;font-size: 12px;font-weight: 500;font-family:Roboto;">
									<img src="https://image.flaticon.com/icons/png/512/25/25377.png" height="10" width="10" style="margin-right: 5px;"> +{{$user->contacts ? $user->contacts->country ? $user->contacts->country->phonecode : "" : ""}} {{$user->contacts ? $user->contacts->number : ""}} 
								</label>
								<label style="color: #000000;margin: 10px 10px 0 10px;display: block;font-size: 12px;font-weight: 500;font-family:Roboto;">
									<img src="https://toppng.com/uploads/preview/email-envelope-letter-send-inbox-newsletter-png-email-icon-transparent-background-11562853327aagu7825m3.png" height="10" width="10" style="margin-right: 5px;"> {{$user->email}}
								</label>
								<label style="color: #000000;margin: 10px 10px 0 10px;display: block;font-size: 12px;font-weight: 500;font-family:Roboto;">
									<img src="https://image.flaticon.com/icons/png/512/67/67872.png" height="10" width="10" style="margin-right: 5px;"> {{$user->address ? $user->address->street : ""}}, {{$user->address? $user->address->city : ""}}, {{$user->address ? $user->address->country->getName() : ""}}
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
			
			<br>
			<br>

			{!!$actions!!}
		</div>
	</div>
</div>