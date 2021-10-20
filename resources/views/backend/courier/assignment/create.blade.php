@extends('layouts.app')
@section('title', __('custom.assign_courier'))
@section('css')
	<style>
		#container {
			width: 640px;
			margin: 20px auto;
			padding: 10px;
		}

		#interactive.viewport {
			width: 640px;
			height: 250px;
		}


		#interactive.viewport canvas, video {
			float: left;
			width: 90%;
			height: 240px;
		}

		#interactive.viewport canvas.drawingBuffer, video.drawingBuffer {
			margin-left: -640px;
		}

		.controls fieldset {
			border: none;
			margin: 0;
			padding: 0;
		}

		.controls .input-group {
			float: left;
		}

		.controls .input-group input, .controls .input-group button {
			display: block;
		}

		.controls .reader-config-group {
			float: right;
		}

		.controls .reader-config-group label {
			display: block;
		}

		.controls .reader-config-group label span {
			width: 9rem;
			display: inline-block;
			text-align: right;
		}

		.controls:after {
			content: '';
			display: block;
			clear: both;
		}


		#result_strip {
			margin: 10px 0;
			border-top: 1px solid #EEE;
			border-bottom: 1px solid #EEE;
			padding: 10px 0;
		}

		#result_strip > ul {
			padding: 0;
			margin: 0;
			list-style-type: none;
			width: auto;
			overflow-x: auto;
			overflow-y: hidden;
			white-space: nowrap;
		}

		#result_strip > ul > li {
			display: inline-block;
			vertical-align: middle;
			width: 160px;
		}

		#result_strip > ul > li .thumbnail {
			padding: 5px;
			margin: 4px;
			border: 1px dashed #CCC;
		}

		#result_strip > ul > li .thumbnail img {
			max-width: 140px;
		}

		#result_strip > ul > li .thumbnail .caption {
			white-space: normal;
		}

		#result_strip > ul > li .thumbnail .caption h4 {
			text-align: center;
			word-wrap: break-word;
			height: 40px;
			margin: 0px;
		}

		#result_strip > ul:after {
			content: "";
			display: table;
			clear: both;
		}


		.scanner-overlay {
			display: none;
			width: 640px;
			height: 510px;
			position: absolute;
			padding: 20px;
			top: 50%;
			margin-top: -275px;
			left: 50%;
			margin-left: -340px;
			background-color: #FFF;
			-moz-box-shadow: #333333 0px 4px 10px;
			-webkit-box-shadow: #333333 0px 4px 10px;
			box-shadow: #333333 0px 4px 10px;
		}

		.scanner-overlay > .header {
			position: relative;
			margin-bottom: 14px;
		}

		.scanner-overlay > .header h4, .scanner-overlay > .header .close {
			line-height: 16px;
		}

		.scanner-overlay > .header h4 {
			margin: 0px;
			padding: 0px;
		}

		.scanner-overlay > .header .close {
			position: absolute;
			right: 0px;
			top: 0px;
			height: 16px;
			width: 16px;
			text-align: center;
			font-weight: bold;
			font-size: 14px;
			cursor: pointer;
		}


		i.icon-24-scan {
			width: 24px;
			height: 24px;
			background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QzFFMjMzNTBFNjcwMTFFMkIzMERGOUMzMzEzM0E1QUMiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QzFFMjMzNTFFNjcwMTFFMkIzMERGOUMzMzEzM0E1QUMiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpDMUUyMzM0RUU2NzAxMUUyQjMwREY5QzMzMTMzQTVBQyIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpDMUUyMzM0RkU2NzAxMUUyQjMwREY5QzMzMTMzQTVBQyIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PtQr90wAAAUuSURBVHjanFVLbFRVGP7ua97T9DGPthbamAYYBNSMVbBpjCliWWGIEBMWsnDJxkh8RDeEDW5MDGticMmGBWnSlRSCwgLFNkqmmrRIqzjTznTazkxn5s7c6/efzm0G0Jhwkj/nP+d/nv91tIWFBTQaDQWapkGW67p4ltUub5qmAi0UCqF/a/U2m81tpmddotwwDGSz2dzi4uKSaOucnJycGhsbe1XXdQiIIcdxEAgEtgXq9brySHCht79UXi/8QheawN27d385fPjwuEl6XyKR6LdtW7t06RLK5TKOHj2K/fv3Q87Dw8OYn5/HiRMnMDs7i5mZGQwODiqlPp8PuVwO6XRaOXb16lXl1OnTp5FMJvtosF8M+MWLarWqGJaWlpBKpRRcu3YN4+PjmJ6exsTEhDJw5coVjI6OKgPhcBiZTAbxeBx+vx+XL19Gd3c3Tp48Ka9zqDYgBlTQxYNgMIhIJKLCILkQb+TZsgvdsiyFi+feWRR7oRNZyanQtvW2V4DEUUBiK2eJpeDirSyhCe7F2QPh8fiEp72i9PbsC5G52DbiKZA771yr1dTuGfJ4PQNPFoAyQNR1aNEmsS5eyB3PgjeooMZd2AWvNmzYci/Gea7TeFOcI93jV/K67noGmi4vdRI9gPSDeMLSdKUBZZczlWm1rTtHjLZ24d+WER2tc8N1m+Y+ID74wx0zGYvhg9UNrJdtHJyZRdQfwPsrq9g99xsGlgsYmr6BNzO/IVwsYfjBQ6XYz6JI/72MV366B5/lw0elOkJWGUM3bmKtWjXSLuLaBWhnPnnp0FfoiFi4+TMfVAb2poBkDLjO845uYLEAjL4ALGWBP5YAOsP4AJYBFDaB1HOSVWD2PuV95H2RdV93Lv74/cf6p6Zxq/h6OofeOPJBC39JtONdwOAAViOs4p4OFGTf0Uc8iiyrr9YdQrUnDLsngrVOC0jQib44HlF2RafRZBz1Qy+vfhgK3NJZBlrm+LEm9qWwzFgLU7Ozg0JxZP06jQSRpQ7EerAWDSt6PuhHPmChEAog56fCLvJT5hHTm3OZkz3DyLx7XNWTGEA1GkV14gjWgwbW0ESVjYRwCOuai03L5E7OUBAV4kXSS4auoGIaKOma4m8EA5R1sMEGLh95C+XuLph0WJWpxepYYLtfT0RRgY1KgNODY6BoaChRuEhDCIZQYseuki5KN6hcQHiq7OZNv4/Zq2O6P4Lfkwn46vZjjaYZrIpvWbpzjLErrc4xUGE4avRedpYJalRcIl5hQius/SrPm9xrNOQYJhao6BvNUeWqtY8KaWuNjHOFAr7mM9f4NA4UbKysoUJ8PV9UzVOx6wxDDWUOxnK1pmCD07fOMAvtIsM3l89Dl3HRGhVma9AZMqjOnz2LQqWCxs6dqr3T7x1DTzKJaG8SekcHhg4cgI/56uKdlKnBV/WndqN3YAB/7tyBd3oT6GBIOzs7kc/nDfFdDFT5bS73cp06dQoaPa/Rw/rtO/resTHxxE2m9rCrbSR27UJCcMf1BpiA5rAAGgdfc868fUR1sMwj0cm9Iu9IctweisViB3hhKTHDcHc5jv/LspbyaZrR1OD82/fIlOkuB9LnEWRmDX2TsddUPg3D5gvuc0je0rZaD5EW6G3yjS+A3eeBEWq3XW/Abw1HhUspXADufQb86oW7tZytkYCN//3hHwBvDALPi8EnSOYK8DAOfCc2h4aGcO7cuafkzampqf9UripH12/DtOZbx8ciVGzYy5OO40o25ascGRl5Ssc/AgwAjW3JwqIUjSYAAAAASUVORK5CYII=");
			display: inline-block;
			background-repeat: no-repeat;
			line-height: 24px;
			margin-top: 1px;
			vertical-align: text-top;
		}

		@media (max-width: 603px) {

			#container {
				width: 300px;
				margin: 10px auto;
				-moz-box-shadow: none;
				-webkit-box-shadow: none;
				box-shadow: none;
			}

			#container form.voucher-form input.voucher-code {
				width: 180px;
			}
		}
		@media (max-width: 603px) {

			.reader-config-group {
				width: 100%;
			}

			.reader-config-group label > span {
				width: 50%;
			}

			.reader-config-group label > select, .reader-config-group label > input {
				max-width: calc(50% - 2px);
			}

			#interactive.viewport {
				width: 300px;
				height: 150px;
				overflow: hidden;
			}


			/*#interactive.viewport canvas, video {*/
			/*	margin-top: -50px;*/
			/*	width: 90%;*/
			/*	height: 200px;*/
			/*}*/

			#interactive.viewport canvas.drawingBuffer, video.drawingBuffer {
				margin-left: -300px;
			}


			#result_strip {
				margin-top: 5px;
				padding-top: 5px;
			}

			#result_strip ul.thumbnails > li {
				width: 150px;
			}

			#result_strip ul.thumbnails > li .thumbnail .imgWrapper {
				width: 130px;
				height: 130px;
				overflow: hidden;
			}

			#result_strip ul.thumbnails > li .thumbnail .imgWrapper img {
				margin-top: -25px;
				width: 130px;
				height: 180px;
			}
		}
		@media (max-width: 603px) {

			.overlay.scanner {
				width: 640px;
				height: 510px;
				padding: 20px;
				margin-top: -275px;
				margin-left: -340px;
				background-color: #FFF;
				-moz-box-shadow: none;
				-webkit-box-shadow: none;
				box-shadow: none;
			}

			.overlay.scanner > .header {
				margin-bottom: 14px;
			}

			.overlay.scanner > .header h4, .overlay.scanner > .header .close {
				line-height: 16px;
			}

			.overlay.scanner > .header .close {
				height: 16px;
				width: 16px;
			}
		}
	</style>
@endsection
@section('content')

	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>@lang('custom.assign_courier')</h1>
	</section>

	<!-- Main content -->
	<section class="content no-print">
		{!! Form::open(['url' => action('CourierAssigmentController@store'), 'method' => 'post', 'id' => 'stock_transfer_form' ]) !!}
		<div class="box box-solid">
			<div class="box-body">
				<div class="row">
					<div class="col-sm-3">
						<div class="form-group">
							{!! Form::label('date', __('messages.date') . ':*') !!}
							<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</span>
								{!! Form::text('date', @format_datetime('now'), ['class' => 'form-control', 'id'=>'date','readonly', 'required']); !!}
							</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							{!! Form::label('ref_no', __('purchase.ref_no').':') !!}
							{!! Form::text('ref_no', null, ['class' => 'form-control']); !!}
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							{!! Form::label('courier_id', __('custom.courier').':*') !!}
							{!! Form::select('courier_id', $couriers, null, ['class' => 'form-control select2', 'placeholder' => __('messages.please_select'), 'required', 'id' => 'courier_id']); !!}
						</div>
					</div>

				</div>
			</div>
		</div> <!--box end-->
		@component('components.filters', ['title' => __('custom.Camera settings'),'class'=>'hidden','closed'=>1, 'icon'=>'<i class="fa fa-camera" aria-hidden="true"></i>'])
			<div class="controls">
				<fieldset class="reader-config-group">
					<label>
						<span>Barcode-Type</span>
						<select name="decoder_readers">
							<option value="code_128" selected="selected">Code 128</option>
							<option value="code_39">Code 39</option>
							<option value="code_39_vin">Code 39 VIN</option>
							<option value="ean">EAN</option>
							<option value="ean_extended">EAN-extended</option>
							<option value="ean_8">EAN-8</option>
							<option value="upc">UPC</option>
							<option value="upc_e">UPC-E</option>
							<option value="codabar">Codabar</option>
							<option value="i2of5">Interleaved 2 of 5</option>
							<option value="2of5">Standard 2 of 5</option>
							<option value="code_93">Code 93</option>
						</select>
					</label>
					<label>
						<span>Resolution (width)</span>
						<select name="input-stream_constraints">
							<option value="320x240">320px</option>
							<option selected="selected" value="640x480">640px</option>
							<option value="800x600">800px</option>
							<option value="1280x720">1280px</option>
							<option value="1600x960">1600px</option>
							<option value="1920x1080">1920px</option>
						</select>
					</label>
					<label>
						<span>Patch-Size</span>
						<select name="locator_patch-size">
							<option value="x-small">x-small</option>
							<option value="small">small</option>
							<option selected="selected" value="medium">medium</option>
							<option value="large">large</option>
							<option value="x-large">x-large</option>
						</select>
					</label>
					<label>
						<span>Half-Sample</span>
						<input type="checkbox" checked="checked" name="locator_half-sample" />
					</label>
					<label>
						<span>Workers</span>
						<select name="numOfWorkers">
							<option value="0">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option selected="selected" value="4">4</option>
							<option value="8">8</option>
						</select>
					</label>
					<label>
						<span>Camera</span>
						<select name="input-stream_constraints" id="deviceSelection">
						</select>
					</label>
					<label style="display: none">
						<span>Zoom</span>
						<select name="settings_zoom"></select>
					</label>
					<label style="display: none">
						<span>Torch</span>
						<input type="checkbox" name="settings_torch" />
					</label>
				</fieldset>
			</div>
		@endcomponent
		<div id="camera_view" class="box box-solid hidden">
			<div class="box-body">
				<div id="container" class="container">
					<div id="interactive" class="viewport"></div>
				</div>
				<div class="btn-group text-center controls" data-toggle="buttons">
					<button class="btn btn-info start">On</button>
					<button class="btn btn-info stop">Off</button>
				</div>
			</div>
		</div>
		<div class="box box-solid">
			<div class="box-header">
				<h3 class="box-title">{{ __('stock_adjustment.search_products') }}</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<div class="form-group">
							<div class="input-group">
							<span class="input-group-addon">
								<i class="fa fa-search"></i>
							</span>
								{!! Form::text('search_order', null, ['class' => 'form-control', 'id' => 'search_order', 'placeholder' => __('custom.search_order'), 'disabled']); !!}
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<input type="hidden" id="product_row_index" value="0">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-condensed"
								   id="stock_adjustment_product_table">
								<thead>
								<tr>
									<th class="col-sm-2 text-center">
										@lang('receipt.invoice_number')
									</th>
									<th class="col-sm-2 text-center">
										@lang('business.name')
									</th>
									<th class="col-sm-2 text-center">
										@lang('business.address')
									</th>
									<th class="col-sm-2 text-center">
										@lang('contact.mobile')
									</th>
									<th class=" col-sm-2 text-center">
										Area
									</th>
									<th  class=" col-sm-2 text-center">
										Zone
									</th>
									<th class="col-sm-2 text-center">
										@lang('sale.amount')
									</th>
									<th class="col-sm-2 text-center">
										@lang('lang_v1.total_items')
									</th>
									<th class="col-sm-2 text-center"><i class="fa fa-trash" aria-hidden="true"></i></th>
								</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div> <!--box end-->
		<div class="box box-solid">
			<div class="box-body">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							{!! Form::label('note',__('purchase.additional_notes')) !!}
							{!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => 3]); !!}
						</div>
					</div>
					<div class="col-sm-8">
						<table class="table table-bordered">
							<tr>
								<td>Total amount:</td>
								<td><input type="hidden" min="0" value="0" step="any" id="total_amount_input" name="total_amount" > <span id="total_amount">0</span></td>
							</tr>
							<tr>
								<td>Total parcel:</td>
								<td><input type="hidden" id="total_parcel_input" name="total_order" value="0"> <span id="total_parcel">0</span></td>
							</tr>
							<tr>
								<td>Total items</td>
								<td><span id="total_items">0</span></td>
							</tr>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<button type="submit" id="save_stock_transfer" class="btn btn-primary pull-right">@lang('messages.save')</button>
					</div>
				</div>
				<audio id="scan-audio">
					<source src="{{asset('audio/barcode.mp3?v=' . $asset_v)}}" type="audio/mpeg">
				</audio>

			</div>
		</div> <!--box end-->
		{!! Form::close() !!}
	</section>
@stop
@section('javascript')
	{{--	<script src="{{ asset('js/stock_transfer.js?v=' . $asset_v) }}"></script>--}}
	<script>
		$('#stock_transfer_form').on('submit', function (form) {
			$('#save_stock_transfer').prop('disabled', true);
		})
		var listed=[];
		$('#date').datetimepicker({
			format: moment_date_format + ' ' + moment_time_format,
			ignoreReadonly: true,
		});
		$(document).ready(function() {
			if ($('#search_order').length > 0) {
				//Add Product
				$('#search_order')
						.autocomplete({
							source: function(request, response) {
								$.getJSON(
										'/courier-assignment/orders',
										{query: request.term },
										response
								);
							},
							minLength: 2,
							response: function(event, ui) {
								if (ui.content.length == 1) {
									ui.item = ui.content[0];
									if (!ui.item.courier_id) {
										$(this)
												.data('ui-autocomplete')
												._trigger('select', 'autocompleteselect', ui);
										$(this).autocomplete('close');
									}
								} else if (ui.content.length == 0) {
									swal(LANG.no_products_found);
								}
							},
							focus: function(event, ui) {
								if (ui.item.courier_id > 0) {
									return false;
								}
							},
							select: function(event, ui) {
								if (!ui.item.courier_id) {
									if(listed.includes(ui.item.id)){
										alert('already added in the list')
										return
									}
									$(this).val(null);
									listed.push(ui.item.id);
									stock_transfer_product_row(ui.item.id);
								} else {
									alert('Already assigned once');
								}
							},
						})
						.autocomplete('instance')._renderItem = function(ul, item) {
					if (item.courier_id) {
						var string = '<li class="ui-state-disabled">' + item.invoice_no;

						string += '(Already assigned to '+item.courier_name+') </li>';
						return $(string).appendTo(ul);
					} else {
						var string = '<div>' + item.invoice_no;
						string += '</div>';
						return $('<li>')
								.append(string)
								.appendTo(ul);
					}
				};
			}
			$(document).on('click', '.remove_product_row', function() {
				swal({
					title: LANG.sure,
					icon: 'warning',
					buttons: true,
					dangerMode: true,
				}).then(willDelete => {
					if (willDelete) {
						$(this)
								.closest('tr')
								.remove();
						var id = $(this).data('id');
						var index = listed.indexOf(id);
						listed.splice(index, 1);
						update_table_total()
					}
				});
			});
			$('#stock_transfer_form').on('submit', function (form) {
				$('#save_stock_transfer').prop('disabled', true);
			});
			$('select#courier_id').change(function () {
				if ($(this).val()) {
					$('#search_order').removeAttr('disabled');
				} else {
					$('#search_order').attr('disabled', 'disabled');
				}
			});
			function stock_transfer_product_row(variation_id) {
				var row_index = parseInt($('#product_row_index').val());
				var location_id = $('select#location_id').val();
				var courier_id = $('#courier_id').val();
				$.ajax({
					method: 'POST',
					url: '/courier-assignment/get_sell_row',
					data: { row_index: row_index, id: variation_id, courier_id:courier_id},
					dataType: 'html',
					success: function(result) {
						$('table#stock_adjustment_product_table tbody').prepend(result);
						$('#'+row_index+'_city').select2();
						$(document).on('change', '#'+row_index+'_city', function () {
							var city = $(this).val();
							data = zones.filter(z => z.city_id == city)
							$('#'+row_index+'_zone').empty().select2({
								data: data
							});
						});
						var city_id = $('#'+row_index+"_city_value").val();
						var zone_id = $('#'+row_index+"_zone_value").val();
						if (city_id){
							$('#'+row_index+'_city').val(city_id).trigger('change');
							$('#'+row_index+'_zone').val(zone_id).trigger('change');
						}
						update_table_total();
						$('#product_row_index').val(row_index + 1);
					},
				});
			}
		});
		function update_table_total() {
			var table_total = 0;
			$('table#stock_adjustment_product_table tbody tr').each(function() {
				var this_total = parseFloat(__read_number($(this).find('input.product_line_total')));
				if (this_total) {
					table_total += this_total;
				}
			});
			var amount_total = 0;
			$('table#stock_adjustment_product_table tbody tr').each(function() {
				var this_total = parseFloat(__read_number($(this).find('input.amount_line_total')));
				if (this_total) {
					amount_total += this_total;
				}
			});
			$('#total_amount_input').val(amount_total);
			$('#total_amount').text(__number_f(amount_total));
			$('#total_items').text(__number_f(table_total));
			$('#total_parcel').text(__number_f(listed.length));
			$('#total_parcel_input').val(listed.length);
		}
	</script>
	<script type="text/javascript">
		__page_leave_confirmation('#stock_transfer_form');
	</script>
<script src="{{@asset('js/quagga.js')}}" type="text/javascript"></script>
<script>
	var isMobile = false; //initiate as false
	// device detection
	if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
			|| /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
		isMobile = true;
	}
	if (isMobile){
		$('#accordion').removeClass('hidden');
		$('#camera_view').removeClass('hidden');
		$(function() {
			var resultCollector = Quagga.ResultCollector.create({
				capture: true,
				capacity: 20,
				blacklist: [{
					code: "WIWV8ETQZ1", format: "code_93"
				}, {
					code: "EH3C-%GU23RK3", format: "code_93"
				}, {
					code: "O308SIHQOXN5SA/PJ", format: "code_93"
				}, {
					code: "DG7Q$TV8JQ/EN", format: "code_93"
				}, {
					code: "VOFD1DB5A.1F6QU", format: "code_93"
				}, {
					code: "4SO64P4X8 U4YUU1T-", format: "code_93"
				}],
				filter: function(codeResult) {
					// only store results which match this constraint
					// e.g.: codeResult
					return true;
				}
			});
			var App = {
				init: function() {
					var self = this;

					Quagga.init(this.state, function(err) {
						if (err) {
							return self.handleError(err);
						}
						//Quagga.registerResultCollector(resultCollector);
						App.attachListeners();
						App.checkCapabilities();
						Quagga.start();
					});
				},
				handleError: function(err) {
					console.log(err);
				},
				checkCapabilities: function() {
					var track = Quagga.CameraAccess.getActiveTrack();
					var capabilities = {};
					if (typeof track.getCapabilities === 'function') {
						capabilities = track.getCapabilities();
					}
					this.applySettingsVisibility('zoom', capabilities.zoom);
					this.applySettingsVisibility('torch', capabilities.torch);
				},
				updateOptionsForMediaRange: function(node, range) {
					console.log('updateOptionsForMediaRange', node, range);
					var NUM_STEPS = 6;
					var stepSize = (range.max - range.min) / NUM_STEPS;
					var option;
					var value;
					while (node.firstChild) {
						node.removeChild(node.firstChild);
					}
					for (var i = 0; i <= NUM_STEPS; i++) {
						value = range.min + (stepSize * i);
						option = document.createElement('option');
						option.value = value;
						option.innerHTML = value;
						node.appendChild(option);
					}
				},
				applySettingsVisibility: function(setting, capability) {
					// depending on type of capability
					if (typeof capability === 'boolean') {
						var node = document.querySelector('input[name="settings_' + setting + '"]');
						if (node) {
							node.parentNode.style.display = capability ? 'block' : 'none';
						}
						return;
					}
					if (window.MediaSettingsRange && capability instanceof window.MediaSettingsRange) {
						var node = document.querySelector('select[name="settings_' + setting + '"]');
						if (node) {
							this.updateOptionsForMediaRange(node, capability);
							node.parentNode.style.display = 'block';
						}
						return;
					}
				},
				initCameraSelection: function(){
					var streamLabel = Quagga.CameraAccess.getActiveStreamLabel();

					return Quagga.CameraAccess.enumerateVideoDevices()
							.then(function(devices) {
								function pruneText(text) {
									return text.length > 30 ? text.substr(0, 30) : text;
								}
								var $deviceSelection = document.getElementById("deviceSelection");
								while ($deviceSelection.firstChild) {
									$deviceSelection.removeChild($deviceSelection.firstChild);
								}
								devices.forEach(function(device) {
									var $option = document.createElement("option");
									$option.value = device.deviceId || device.id;
									$option.appendChild(document.createTextNode(pruneText(device.label || device.deviceId || device.id)));
									$option.selected = streamLabel === device.label;
									$deviceSelection.appendChild($option);
								});
							});
				},
				attachListeners: function() {
					var self = this;

					self.initCameraSelection();
					$(".controls").on("click", "button.stop", function(e) {
						e.preventDefault();
						Quagga.stop();
						self._printCollectedResults();
					});
					$(".controls").on("click", "button.start", function(e) {
						e.preventDefault();
						App.init();
					});

					$(".controls .reader-config-group").on("change", "input, select", function(e) {
						e.preventDefault();
						var $target = $(e.target),
								value = $target.attr("type") === "checkbox" ? $target.prop("checked") : $target.val(),
								name = $target.attr("name"),
								state = self._convertNameToState(name);

						console.log("Value of "+ state + " changed to " + value);
						self.setState(state, value);
					});
				},
				_printCollectedResults: function() {
					var results = resultCollector.getResults(),
							$ul = $("#result_strip ul.collector");

					results.forEach(function(result) {
						var $li = $('<li><div class="thumbnail"><div class="imgWrapper"><img /></div><div class="caption"><h4 class="code"></h4></div></div></li>');

						$li.find("img").attr("src", result.frame);
						$li.find("h4.code").html(result.codeResult.code + " (" + result.codeResult.format + ")");
						$ul.prepend($li);
					});
				},
				_accessByPath: function(obj, path, val) {
					var parts = path.split('.'),
							depth = parts.length,
							setter = (typeof val !== "undefined") ? true : false;

					return parts.reduce(function(o, key, i) {
						if (setter && (i + 1) === depth) {
							if (typeof o[key] === "object" && typeof val === "object") {
								Object.assign(o[key], val);
							} else {
								o[key] = val;
							}
						}
						return key in o ? o[key] : {};
					}, obj);
				},
				_convertNameToState: function(name) {
					return name.replace("_", ".").split("-").reduce(function(result, value) {
						return result + value.charAt(0).toUpperCase() + value.substring(1);
					});
				},
				detachListeners: function() {
					$(".controls").off("click", "button.stop");
					$(".controls .reader-config-group").off("change", "input, select");
				},
				applySetting: function(setting, value) {
					var track = Quagga.CameraAccess.getActiveTrack();
					if (track && typeof track.getCapabilities === 'function') {
						switch (setting) {
							case 'zoom':
								return track.applyConstraints({advanced: [{zoom: parseFloat(value)}]});
							case 'torch':
								return track.applyConstraints({advanced: [{torch: !!value}]});
						}
					}
				},
				setState: function(path, value) {
					var self = this;

					if (typeof self._accessByPath(self.inputMapper, path) === "function") {
						value = self._accessByPath(self.inputMapper, path)(value);
					}

					if (path.startsWith('settings.')) {
						var setting = path.substring(9);
						return self.applySetting(setting, value);
					}
					self._accessByPath(self.state, path, value);

					console.log(JSON.stringify(self.state));
					App.detachListeners();
					Quagga.stop();
					App.init();
				},
				inputMapper: {
					inputStream: {
						constraints: function(value){
							if (/^(\d+)x(\d+)$/.test(value)) {
								var values = value.split('x');
								return {
									width: {min: parseInt(values[0])},
									height: {min: parseInt(values[1])}
								};
							}
							return {
								deviceId: value
							};
						}
					},
					numOfWorkers: function(value) {
						return parseInt(value);
					},
					decoder: {
						readers: function(value) {
							if (value === 'ean_extended') {
								return [{
									format: "ean_reader",
									config: {
										supplements: [
											'ean_5_reader', 'ean_2_reader'
										]
									}
								}];
							}
							return [{
								format: value + "_reader",
								config: {}
							}];
						}
					}
				},
				state: {
					inputStream: {
						type : "LiveStream",
						constraints: {
							width: {min: 640},
							height: {min: 480},
							facingMode: "environment",
							aspectRatio: {min: 1, max: 2}
						}
					},
					locator: {
						patchSize: "medium",
						halfSample: true
					},
					numOfWorkers: 2,
					frequency: 10,
					decoder: {
						readers : [{
							format: "code_128_reader",
							config: {}
						}]
					},
					locate: true
				},
				lastResult : null
			};

			App.init();

			Quagga.onProcessed(function(result) {
				var drawingCtx = Quagga.canvas.ctx.overlay,
						drawingCanvas = Quagga.canvas.dom.overlay;

				if (result) {
					if (result.boxes) {
						drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
						result.boxes.filter(function (box) {
							return box !== result.box;
						}).forEach(function (box) {
							Quagga.ImageDebug.drawPath(box, {x: 0, y: 1}, drawingCtx, {color: "green", lineWidth: 2});
						});
					}

					if (result.box) {
						Quagga.ImageDebug.drawPath(result.box, {x: 0, y: 1}, drawingCtx, {color: "#00F", lineWidth: 2});
					}

					if (result.codeResult && result.codeResult.code) {
						Quagga.ImageDebug.drawPath(result.line, {x: 'x', y: 'y'}, drawingCtx, {color: 'red', lineWidth: 3});
					}
				}
			});

			Quagga.onDetected(function(result) {
				var code = result.codeResult.code;

				if (App.lastResult !== code) {
					App.lastResult = code;
					$('#search_order').val(code).change();
					$('#search_order').autocomplete( "search");
					var audio = $('#scan-audio')[0];
					if (audio !== undefined) {
						audio.play();
					}
				}
			});

		});
	}

</script>
@endsection
