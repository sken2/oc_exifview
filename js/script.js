/**
 * ownCloud - exifview
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author shi <shi@example.com>
 * @copyright shi 2015
 */
(function ($, OC, ol) {

	$(document).ready(function () {
		$('button[name=list]').click(function() {
			var data='';
			var url = OC.generateUrl('/apps/exifview/show');
			$.get(url, data). done(function (response) {
				console.log(response);
				var table=$('#filelist')[0];
				while (table.firstChild) {
					table.removeChild(table.firstChild);
				}
				response.forEach(function (img){
console.log(img.path);
					table.appendChild(createItem(img));
				});
			}).fail(function(r){
				console.log('failed');
			});
		});

		$('#filelist').click(function(evt){
			var tgt = evt.target;
			switch(tgt.nodeName) {
			case 'SPAN':
				var fileid = tgt.getAttribute('fileid');
				var path = encodeURIComponent(tgt.firstChild.nodeValue);
				var url = OC.generateUrl('/apps/exifview/show/')+path;
				$.get(url, {}).done(function(r){
					console.log(r);
				}).fail(function(r){
					console.log('id_fail');
				});
				break;
			case 'BUTTON':
				console.log(tgt);
				switch (tgt.name) {
				case 'get_time':
					span = tgt.parentNode.firstChild;//!
					var fileid = tgt.parentNode.getAttribute('fileid');
					var path = encodeURIComponent(span.firstChild.nodeValue);//!
					var url = OC.generateUrl('/apps/exifview/time/')+path;
					$.get(url, {}).done(function(r){
						console.log(r);
					}).fail(function(r){
						console.log('id_fail');
					});
					break;
				case 'get_loc':
					span = tgt.parentNode.firstChild;//!
					var fileid = tgt.parentNode.getAttribute('fileid');
					var path = encodeURIComponent(span.firstChild.nodeValue);//!
					var url = OC.generateUrl('/apps/exifview/time/')+path;
					$.get(url, {}).done(function(r){
						console.log(r);
						if(r) {
							var url = OC.generateUrl('/apps/gpstracks/gpxmatch/')+r.FileDateTime;
							$.get(url, {}).done(function(rr){
								console.log(rr);
								if(rr.length){
									dispmap(rr[0]);
								}
							}).fail(function(xhr){
								console.log(xhr);
							});
						}
					}).fail(function(r){
						console.log('id_fail');
					});
					break;
				}
				break;
			default:
				;
			}
		});

		//for debug
		$('button[name=test]').click(function(){
			var url = OC.generateUrl('/apps/exifview/test/1');
			$.get(url, {}).always(function(r){
				console.log(r);
			});
		});
	});
			
	function createItem(obj) {
		var item = document.createElement('LI');
		var pic_name = document.createElement('SPAN');
		var pic_thumb = document.createElement('IMG');
		var time_btn = document.createElement('BUTTON');
		time_btn.setAttribute('name', 'get_time');
		time_btn.appendChild(document.createTextNode('Time'));
		var loc_btn = document.createElement('BUTTON');
		loc_btn.setAttribute('name', 'get_loc');
		loc_btn.appendChild(document.createTextNode('Location'));

		item.appendChild(pic_name);
		item.appendChild(time_btn);
		item.appendChild(loc_btn);

		if(obj){
			pic_name.appendChild(document.createTextNode(obj.path));
			item.setAttribute('fileid', obj.fileid);
		}
		return item;
	}

	function dispmap(coord) {
		OCA.OwnLayer.open(coord.lon, coord.lat);
		OCA.OwnLayer.plot('Picture Location', {lat:coord.lat, lon:coord.lon});
	}

})(jQuery, OC, ol);
