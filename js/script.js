/**
 * ownCloud - exifview
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author shi <shi@example.com>
 * @copyright shi 2015
 */

(function ($, OC) {

	$(document).ready(function () {
		$('#hello').click(function () {
			alert('Hello from your script file');
		});

		$('#echo').click(function () {
			var url = OC.generateUrl('/apps/exifview/echo');
			var data = {
				echo: $('#echo-content').val()
			};

			$.post(url, data).success(function (response) {
				$('#echo-result').text(response.echo);
			});

		});

		$('button[name=list]').click(function() {
			var url = OC.generateUrl('/apps/exifview/img');
			var data='';
			$.get(url, data). success(function (response) {
				console.log(response);
				var table=$('#img-list')[0];
				response.forEach(function (img){
console.log(img.path);
					var p = document.createElement('P');
					var t = document.createTextNode(img.path);
					table.appendChild(p);
					p.appendChild(t);
					p.setAttribute('fileid', img.fileid);
//					p.appendChild(document.createTextNode(img.path));
//					$('#img-list').add(t);
//					table.appendChild(t);
				});
				$('#img-list p').click(function(){
					var fileid=this.getAttribute('fileid');
					console.log(fileid);
					var url_id=url+"/"+fileid;
					$.get(url_id, data).success(function(r){
						console.log(r);
					}).fail(function(r){
						console.log('id_fail');
					});
				});
			}).fail(function(r){
				console.log('failed');
			});
		});
	});

})(jQuery, OC);
