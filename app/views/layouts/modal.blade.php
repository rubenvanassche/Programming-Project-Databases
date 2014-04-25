<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel">{{ $title or ''}}</h4>
	</div>
	<div class="modal-body">
		{{ $content or '' }}
		<br />
	</div>
	<div class="modal-footer">
		{{ $footer or ''}}
	</div>
</div>