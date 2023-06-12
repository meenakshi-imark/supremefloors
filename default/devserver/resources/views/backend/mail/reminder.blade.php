<img src="{{asset('admin/images/logo.png')}}" alt="logo">
@php 
$get = DB::table('users')->where('id',$user['userid'])->select('name')->first();
@endphp
<p>Hi <b>{{$get->name}},</b><br>
Just A Friendly Reminder About Your Flooring Installation.</p>
		  <table class="table">
			  <thead>
				<tr>
				  <th scope="col">Summary</th>
				  <th scope="col">Installation Address</th>
				</tr>
			  </thead>
			  <tbody>
				<tr>
				  <td>Installation Date: {{$user['installation_date']}}<br>
					  Colour: {{$user['end_color']}}<br>
					  Area: {{$user['area']}}
					  </td>
				  <td>{{$user['site_address']}}</td>
				</tr>
			  </tbody>
			</table>
			
			<p>Thankyou!</p>