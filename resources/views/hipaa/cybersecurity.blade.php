@extends('layouts.admin')

@section('page_title')
Cybersecurity Steps to be Taken to keep your PHI Safe
@endsection

@section('content')

<style type="text/css">
	.list-group-item .badge {
		float: none;
	}
	.list-group-item .step {
		margin-left: 20px;
	}
</style>

<div class="row">

	<div class="col-sm-12 col-xs-12">

		<div class="panel panel-default panel-custom">

			<div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <h3 class="panel-title"><i class="fa fa-2x fa-universal-access" aria-hidden="true"></i> Cybersecurity Steps to be Taken to keep your PHI Safe</h3>
                    </div>
                </div>
            </div>

			<div class="panel-body">

				<ul class="list-group">

					<li class="list-group-item">
						<span class="badge">1</span> 
						<span class="step">Appoint appropriate Compliance Officer for Cybersecurity.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">2</span> 
						<span class="step">All staff should have cybersecurity training annually by viewing the Hipaamart training video.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">3</span> 
						<span class="step">Perform Risk Assessment annually.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">4</span> 
						<span class="step">Store and keep a list of all Business Associate Agreements.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">5</span> 
						<span class="step">Assign all staff a unique ID and password.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">6</span> 
						<span class="step">Have an Information Technology individual or company for consultation on cybersecurity.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">7</span> 
						<span class="step">Implement log management to track altering of data.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">8</span> 
						<span class="step">Run a vulnerability scan once a month.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">9</span> 
						<span class="step">Provide appropriate secure encrypted offsite backup.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">10</span> 
						<span class="step">Work with tools that can scan devices for unencrypted patient health information before disposal of devices.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">11</span> 
						<span class="step">Implement offsite encrypted backup storage.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">12</span> 
						<span class="step">Post and distribute Security Compliance Officer contact information.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">13</span> 
						<span class="step">Perform log monitoring.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">14</span> 
						<span class="step">Apply encryption to the data while at rest.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">15</span> 
						<span class="step">Apply encryption to data while in transit.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">16</span> 
						<span class="step">Refer to all Policies and Procedures in HIPAA Container.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">17</span> 
						<span class="step">Implement administrative safeguards.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">18</span> 
						<span class="step">Implement contingency planning testing and procedures.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">19</span> 
						<span class="step">Implement facility security plan.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">20</span> 
						<span class="step">Implement information access policy.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">21</span> 
						<span class="step">Implement Workstation use policy.</span>
					</li>

					<li class="list-group-item">
						<span class="badge">22</span> 
						<span class="step">If appropriate, engage an Information Technology Cybersecurity Expert to implement anti-hacking, anti-ransomware and privacy security software on your local computer network.</span>
					</li>

				</ul>

			</div>

		</div>

	</div>

</div>

@endsection