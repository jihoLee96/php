<!-- Start of Ajax call to upload multiple images--> 
	//var $j=jQuery.noConflict();
jQuery(function($j)
	{
		var nonce_val = $j('#nonce_value').html();
		var xx = document.location.hostname;
		var path_value = $j('#path_value').html();
		var mainPath = xx + path_value;
	   	var path = 'http://'+xx + path_value+'/wp-content/plugins/image-gallery-with-slideshow/';		
		var btnUpload=$j('#upload_image');
		var status=$j('#status');
		new AjaxUpload(btnUpload,
		{		
			action: path+'upload-file.php?_ajax_nonce='+nonce_val,	
			name: 'uploadfilename',		
			onSubmit: function(file, ext)
			{
				if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){	
				// extension is not allowed 
				status.text('Only JPG, PNG or GIF files are allowed');
				return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response)
			{
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				if(response==="success"){
				$j('<li></li>').appendTo('#files').html('<img src="./uploads/original/'+file+'" alt="" /><br />'+file).addClass('success');
				} else{
				$j('<li></li>').appendTo('#files').text(file).addClass('error');
				}
			}
		});
	});
 <!--End of Ajax call to upload multiple images-->
 <!--Start of validation script for gallery and image upload -->

function galleryForm()
{
var x=document.forms["add_gallery"]["gallery_name"].value
if (x==null || x=="")
  {
  alert("Please enter the gallery name");
  return false;
  }
}
function singleimageForm()
{
var x=document.forms["image_upload"]["selectGallery"].value
if (x == 0)
  {
  alert("Please select the gallery name");
  return false;
  }
}
function mulimageForm()
{
var x=document.forms["muntiple_upload"]["selectMulGallery"].value
if (x == 0)
  {
  alert("Please select the gallery name");
  return false;
  }
}
<!-- End of validation script for gallery and image upload -->

jQuery(function($) {
			var $tabs = $('#tabs').tabs();
		});