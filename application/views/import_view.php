<div class="modal-body">
   	<p><strong>Penjelasan : </strong></p>
   	<ul>
   		<li>Download Format Import excel <a href="<?= base_url("assets/format_ci.xlsx"); ?>" target="blank">disini</a>.</li>
   		<li>Isikan data kedalam file format.</li>
    	<li>Upload file excel pada form dibawah.</li>
    </ul>
   	<hr>
    <form action="<?= base_url("siswa/proses_import"); ?>" enctype='multipart/form-data'>
    	<input type="file" id="upload_excel" name="upload_excel">
    	<div class="import_ket"></div>
    </form>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

<script type="text/javascript">
    $(document).ready(function(){
    	
    	var interval;
		function applyAjaxFileUpload(element) {
			$(element).AjaxFileUpload({
				action: "<?= base_url('siswa/proses_import'); ?>",
				onChange: function(filename) {
					// Create a span element to notify the user of an upload in progress
					var $span = $("<span />")
						.attr("class", $(this).attr("id"))
						.text("Uploading")
						.insertAfter($(this));
					$(this).remove();
					interval = window.setInterval(function() {
						var text = $span.text();
						if (text.length < 13) {
							$span.text(text + ".");
						} else {
							$span.text("Uploading");
						}
					}, 200);
				},
				onSubmit: function(filename) {
					// Return false here to cancel the upload
					/*var $fileInput = $("<input />")
						.attr({
							type: "file",
							name: $(this).attr("name"),
							id: $(this).attr("id")
						});
					$("span." + $(this).attr("id")).replaceWith($fileInput);
					applyAjaxFileUpload($fileInput);
					return false;*/
					// Return key-value pair to be sent along with the file
					return true;
				},
				onComplete: function(filename, response) {
					window.clearInterval(interval);
					console.log(filename);
					console.log(response);

					var $span = $("span." + $(this).attr("id")).text("Upload Success!"),
						$fileInput = $("<input />")
							.attr({
								type: "file",
								name: $(this).attr("name"),
								id: $(this).attr("id")
							});
					if (typeof(response.error) === "string") {
						$span.replaceWith($fileInput);
						applyAjaxFileUpload($fileInput);
						alert(response.error);
						return;
					}
					var isi = "<pre style='max-height:200px; overflow-y:scroll'>";
					var sheet = response.sheet;
					var count = 0;
					for(i in sheet){
						if(i>=2){
							//console.log(sheet[i].A);
							//isi += sheet[i].A+" -> Imported.\n"
							count++;
						}
					}
					isi += response.dada;
					isi += "\n"+count+" data imported.\n";
					isi += "</pre>";
					$(".import_ket").html(isi);
					/*$("<a />")
						.attr("href", "#")
						.text("x")
						.bind("click", function(e) {
							$span.replaceWith($fileInput);
							applyAjaxFileUpload($fileInput);
						})
						.appendTo($span);*/
				}
			});
		}

		applyAjaxFileUpload("#upload_excel");

		$("#btn_proses").click(function(){
			
		});
    });
</script>