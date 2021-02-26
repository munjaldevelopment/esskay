<div style="margin: 0px auto; width: 80%; border: 2px #ebebeb solid;padding: 10px;background-color: #ffffff; border-radius: .25rem; font-family:'Open Sans',Helvetica,Arial,sans-serif;">
	<div style="text-align:left; margin:0 20px;">
		<p>Hi <strong>{{ $first_name }} {{ $last_name }}</strong>,</p>
		
		<table class="table">
			<tbody>
				<tr>
					<th scope="row">First Name</th>
					<td>{{ $first_name }}</td>
				</tr>
				
				<tr>
					<th scope="row">Last Name</th>
					<td>{{ $last_name }}</td>
				</tr>
				
				<tr>
					<th scope="row">Email</th>
					<td>{{ $email }}</td>
				</tr>
				
				<tr>
					<th scope="row">Telephone</th>
					<td>{{ $telephone }}</td>
				</tr>
				
				<tr>
					<th scope="row">Message</th>
					<td>{{ $user_message }}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>