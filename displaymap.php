<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Google Maps AJAX + mySQL/PHP Example</title>
    <script src="//maps.googleapis.com/maps/api/js?v=3&amp;sensor=false&amp;key=AIzaSyBPVjThu6L2m1MszhZYdmHAccRYxtidBUM"></script>
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <script type="text/javascript">
    //<![CDATA[
$(document).ready(function() {
//    var customIcons = {
//      restaurant: {
//        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
//        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
//      },
//      bar: {
//        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
//        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
//      }
//    };
var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(33.533333,-7.583333),
        zoom: 2,
        mapTypeId: 'roadmap'
      });
var markarray=[]
    function load() {
     
           for (var i = 0; i < markarray.length; i++) {
             markarray[i].setMap(null);
             } 
            markarray = [];
      console.log("ok")
      var infoWindow = new google.maps.InfoWindow;
      // Change this depending on the name of your PHP file
      downloadUrl("phpsql_xml.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var place = markers[i].getAttribute("place");
          //var address = markers[i].getAttribute("address");
          //var type = markers[i].getAttribute("type");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<b>" + place + "</b>";
          //var icon = customIcons[type] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            //icon: icon.icon,
            //shadow: icon.shadow
          });
          markarray.push(marker);
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
    }
    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }
    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };
      request.open('GET', url, true);
      request.send(null);
    }
    function doNothing() {}
    $("#BtnClicked").live('click',function(){load();});
  setInterval(function() {load();},3000);
});
 //]]>
  </script>

  </head>

  <body>
    <div id="map" style="width: 100%; height: 100%"></div>
    <a href="#" id="BtnClicked">maps</a>
  </body>
</html>