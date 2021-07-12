<div class="mtd-inner-box">
	<div class="mtd-inner committee-main-area">
		<div class="side-body side-body-content side-body-full">
			<div class="insight-container">
				<div class="white-box outstanding-box">
					<div class="outstanding-table">
						<h3>Composition of Board of Directors:</h3>
						<div class="custom-table-area">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th class="text-justify" style="min-width: 140px;">Name of the Director</th>
											<th class="border-bottom">Status</th>
											<th class="border-bottom">Nature of Directorship</th>
										</tr>
									</thead>
									<tbody>
										@foreach($boardData as $row)
										<tr>
											<td class="text-justify">{{ $row->director_name }}</td>
											<td>{{ $row->status }}</td>
											<td>{{ $row->nature_directorship }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>	
							</div>	
						</div>
					</div>
				</div>

				<div class="white-box outstanding-box">
					<div class="outstanding-table">
						<h3>Composition of Audit Committee</h3>
						<div class="custom-table-area">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th class="text-justify" style="min-width: 140px;">Name of the Director</th>
											<th class="border-bottom">Status</th>
											<th class="border-bottom">Nature of Directorship</th>
										</tr>
									</thead>
									<tbody>
										@foreach($auditData as $row)
										<tr>
											<td class="text-justify">{{ $row->director_name }}</td>
											<td>{{ $row->status }}</td>
											<td>{{ $row->nature_directorship }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>	
							</div>	
						</div>
					</div>
				</div>

				<div class="white-box outstanding-box">
					<div class="outstanding-table">
						<h3>Composition of Asset Liability Committee</h3>
						<div class="custom-table-area">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th class="text-justify" style="min-width: 140px;">Name of the Director</th>
											<th class="border-bottom">Status</th>
											<th class="border-bottom">Nature of Directorship</th>
										</tr>
									</thead>
									<tbody>
										@foreach($assetData as $row)
										<tr>
											<td class="text-justify">{{ $row->director_name }}</td>
											<td>{{ $row->status }}</td>
											<td>{{ $row->nature_directorship }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>	
							</div>	
						</div>
					</div>
				</div>

				<div class="white-box outstanding-box">
					<div class="outstanding-table">
						<h3>Composition of Risk Management Committee</h3>
						<div class="custom-table-area">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th class="text-justify" style="min-width: 140px;">Name of the Director</th>
											<th class="border-bottom">Status</th>
											<th class="border-bottom">Nature of Directorship</th>
										</tr>
									</thead>
									<tbody>
										@foreach($riskData as $row)
										<tr>
											<td class="text-justify">{{ $row->director_name }}</td>
											<td>{{ $row->status }}</td>
											<td>{{ $row->nature_directorship }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>	
							</div>	
						</div>
					</div>
				</div>

				<div class="white-box outstanding-box">
					<div class="outstanding-table">
						<h3>Composition of Corporate Social Responsibility Committee</h3>
						<div class="custom-table-area">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th class="text-justify" style="min-width: 140px;">Name of the Director</th>
											<th class="border-bottom">Status</th>
											<th class="border-bottom">Nature of Directorship</th>
										</tr>
									</thead>
									<tbody>
										@foreach($corpData as $row)
										<tr>
											<td class="text-justify">{{ $row->director_name }}</td>
											<td>{{ $row->status }}</td>
											<td>{{ $row->nature_directorship }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>	
							</div>	
						</div>
					</div>
				</div>

				<div class="white-box outstanding-box">
					<div class="outstanding-table">
						<h3>Composition of Nomination & Remuneration Committee</h3>
						<div class="custom-table-area">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th class="text-justify" style="min-width: 140px;">Name of the Director</th>
											<th class="border-bottom">Status</th>
											<th class="border-bottom">Nature of Directorship</th>
										</tr>
									</thead>
									<tbody>
										@foreach($nominationData as $row)
										<tr>
											<td class="text-justify">{{ $row->director_name }}</td>
											<td>{{ $row->status }}</td>
											<td>{{ $row->nature_directorship }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>	
							</div>	
						</div>
					</div>
				</div>

				<div class="white-box outstanding-box">
					<div class="outstanding-table">
						<h3>Composition of IT Strategy Committee</h3>
						<div class="custom-table-area">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th class="text-justify" style="min-width: 140px;">Name of the Director</th>
											<th class="border-bottom">Status</th>
											<th class="border-bottom">Nature of Directorship</th>
										</tr>
									</thead>
									<tbody>
										@foreach($itstrategyData as $row)
										<tr>
											<td class="text-justify">{{ $row->director_name }}</td>
											<td>{{ $row->status }}</td>
											<td>{{ $row->nature_directorship }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>	
							</div>	
						</div>
					</div>
				</div>

				<div class="white-box outstanding-box">
					<div class="outstanding-table">
						<h3>Composition of Executive Committee</h3>
						<div class="custom-table-area">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th class="text-justify" style="min-width: 140px;">Name of the Director</th>
											<th class="border-bottom">Status</th>
											<th class="border-bottom">Nature of Directorship</th>
										</tr>
									</thead>
									<tbody>
										@foreach($executiveData as $row)
										<tr>
											<td class="text-justify">{{ $row->director_name }}</td>
											<td>{{ $row->status }}</td>
											<td>{{ $row->nature_directorship }}</td>
										</tr>
										@endforeach
									</tbody>
								</table>	
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>