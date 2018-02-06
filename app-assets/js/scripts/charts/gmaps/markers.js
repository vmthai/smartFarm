
/** @constructor */
function CssMarker(pos, cn, tf, map) {

  // Now initialize all properties.
  this.position_ = pos;
  this.cn_ = cn;
  this.tf_ = tf;
  this.map = map;

  this.div_ = null;

  this.setMap(map);
}

CssMarker.prototype = new google.maps.OverlayView();

CssMarker.prototype.getPosition = function() {
  return this.position_;
}

CssMarker.prototype.onAdd = function() {

  var me = this;
  var div = document.createElement('div');

  div.style.position = 'absolute';
  div.className = this.cn_;
  div.style.transform = this.tf_;
  
  //div.style.border = 'solid ';
  //div.style.borderWidth = '1px';  
  //div.innerHTML = 'Hello oooooooooooooo';

  google.maps.event.addDomListener(div, "click", function(event) {
    google.maps.event.trigger(me, "click");
  });

  google.maps.event.addDomListener(div, "mouseover", function(event) {
    google.maps.event.trigger(me, "mouseover");
  });

  google.maps.event.addDomListener(div, "mouseout", function(event) {
    google.maps.event.trigger(me, "mouseout");
  });

  this.div_ = div;

  var panes = this.getPanes();
  panes.overlayImage.appendChild(this.div_);

};

CssMarker.prototype.draw = function() {

	var overlayProjection = this.getProjection();
	var pos = overlayProjection.fromLatLngToDivPixel(this.position_);

	var div = this.div_;

	div.style.left = (pos.x) + 'px';
	div.style.top = (pos.y) + 'px';
  //div.style.width = '24px';
  //div.style.height = '24px';

  console.log(div);

};

CssMarker.prototype.onRemove = function() {
  this.div_.parentNode.removeChild(this.div_);
};

CssMarker.prototype.hide = function() {
  if (this.div_) {
    this.div_.style.visibility = 'hidden';
  }
};

CssMarker.prototype.show = function() {
  if (this.div_) {
    this.div_.style.visibility = 'visible';
  }
};

CssMarker.prototype.toggle = function() {
  if (this.div_) {
    if (this.div_.style.visibility === 'hidden') {
      this.show();
    } else {
      this.hide();
    }
  }
};

CssMarker.prototype.toggleDOM = function() {
  if (this.getMap()) {
    this.setMap(null);
  } else {
    this.setMap(this.map_);
  }
};


//


/** @constructor */
function TxtMarker(pos, cn, tf, map, txt) {

  // Now initialize all properties.
  this.position_ = pos;
  this.cn_ = cn;
  this.tf_ = tf;
  this.map_ = map;
  this.txt_ = txt;

  this.div_ = null;

  this.setMap(map);
}

TxtMarker.prototype = new google.maps.OverlayView();

TxtMarker.prototype.getPosition = function() {
  return this.position_;
}

TxtMarker.prototype.onAdd = function() {

  var me = this;
  var div = document.createElement('div');
  //div.style.border = 'none';
  //div.style.border = 'solid ';
  //div.style.borderWidth = '1px';

  div.style.position = 'absolute';
  div.className = this.cn_;
  div.style.transform = this.tf_;
  div.innerHTML = this.txt_;

  google.maps.event.addDomListener(div, "click", function(event) {
    google.maps.event.trigger(me, "click");
  });

  google.maps.event.addDomListener(div, "mouseover", function(event) {
    google.maps.event.trigger(me, "mouseover");
  });

  google.maps.event.addDomListener(div, "mouseout", function(event) {
    google.maps.event.trigger(me, "mouseout");
  });

  this.div_ = div;

  var panes = this.getPanes();
  panes.overlayImage.appendChild(this.div_);

};

TxtMarker.prototype.draw = function() {

	var overlayProjection = this.getProjection();
	var pos = overlayProjection.fromLatLngToDivPixel(this.position_);

	var div = this.div_;

	div.style.left = (pos.x) + 'px';
	div.style.top = (pos.y) + 'px';
  //div.style.width = '24px';
  //div.style.height = '24px';

  console.log(div);

};

TxtMarker.prototype.onRemove = function() {
  this.div_.parentNode.removeChild(this.div_);
};

TxtMarker.prototype.hide = function() {
  if (this.div_) {
    this.div_.style.visibility = 'hidden';
  }
};

TxtMarker.prototype.show = function() {
  if (this.div_) {
    this.div_.style.visibility = 'visible';
  }
};

TxtMarker.prototype.toggle = function() {
  if (this.div_) {
    if (this.div_.style.visibility === 'hidden') {
      this.show();
    } else {
      this.hide();
    }
  }
};

TxtMarker.prototype.toggleDOM = function() {
  if (this.getMap()) {
    this.setMap(null);
  } else {
    this.setMap(this.map_);
  }
};


//


/** @constructor */
function ImgMarker(pos, image, tf, map) {

  // Now initialize all properties.
  this.position_ = pos;
  this.image_ = image;
  this.tf_ = tf;
  this.map_ = map;
  //this.location = pos;

  // Define a property to hold the image's div. We'll
  // actually create this div upon receipt of the onAdd()
  // method so we'll leave it null for now.
  this.div_ = null;

  // Explicitly call setMap on this overlay
  this.setMap(map);
}

ImgMarker.prototype = new google.maps.OverlayView();

ImgMarker.prototype.getPosition = function() {
  return this.position_;
}

/**
 * onAdd is called when the map's panes are ready and the overlay has been
 * added to the map.
 */
ImgMarker.prototype.onAdd = function() {

  var div = document.createElement('div');
  //div.style.border = 'none';
  //div.style.border = 'solid ';
  //div.style.borderWidth = '1px';
  div.style.position = 'absolute';
  div.style.transform = this.tf_;

  // Create the img element and attach it to the div.
  var img = document.createElement('img');
  img.src = this.image_;
  //img.style.width = '100%';
  //img.style.height = '100%';
  div.appendChild(img);

  this.div_ = div;

  // Add the element to the "overlayImage" pane.
  var panes = this.getPanes();
  panes.overlayImage.appendChild(this.div_);
};

ImgMarker.prototype.draw = function() {

  // We use the south-west and north-east
  // coordinates of the overlay to peg it to the correct position and size.
  // To do this, we need to retrieve the projection from the overlay.
  var overlayProjection = this.getProjection();
	var pos = overlayProjection.fromLatLngToDivPixel(this.position_);

	var div = this.div_;

	div.style.left = (pos.x-75) + 'px';
	div.style.top = (pos.y-45) + 'px';
  //div.style.width = '24px';
  //div.style.height = '24px';
  
  console.log(div);  

};

ImgMarker.prototype.onRemove = function() {
  this.div_.parentNode.removeChild(this.div_);
};

// Set the visibility to 'hidden' or 'visible'.
ImgMarker.prototype.hide = function() {
  if (this.div_) {
    // The visibility property must be a string enclosed in quotes.
    this.div_.style.visibility = 'hidden';
  }
};

ImgMarker.prototype.show = function() {
  if (this.div_) {
    this.div_.style.visibility = 'visible';
  }
};

ImgMarker.prototype.toggle = function() {
  if (this.div_) {
    if (this.div_.style.visibility === 'hidden') {
      this.show();
    } else {
      this.hide();
    }
  }
};

// Detach the map from the DOM via toggleDOM().
// Note that if we later reattach the map, it will be visible again,
// because the containing <div> is recreated in the overlay's onAdd() method.
ImgMarker.prototype.toggleDOM = function() {
  if (this.getMap()) {
    // Note: setMap(null) calls OverlayView.onRemove()
    this.setMap(null);
  } else {
    this.setMap(this.map_);
  }
};


//


/** @constructor */
function USGSOverlay(bounds, image, map) {

  // Now initialize all properties.
  this.bounds_ = bounds;
  this.image_ = image;
  this.map_ = map;

  // Define a property to hold the image's div. We'll
  // actually create this div upon receipt of the onAdd()
  // method so we'll leave it null for now.
  this.div_ = null;

  // Explicitly call setMap on this overlay
  this.setMap(map);
}

USGSOverlay.prototype = new google.maps.OverlayView();

/**
 * onAdd is called when the map's panes are ready and the overlay has been
 * added to the map.
 */
USGSOverlay.prototype.onAdd = function() {

  var div = document.createElement('div');
  div.style.border = 'none';
  div.style.borderWidth = '0px';
  div.style.position = 'absolute';

  // Create the img element and attach it to the div.
  var img = document.createElement('img');
  img.src = this.image_;
  img.style.width = '100%';
  img.style.height = '100%';
  div.appendChild(img);

  this.div_ = div;

  // Add the element to the "overlayImage" pane.
  var panes = this.getPanes();
  panes.overlayImage.appendChild(this.div_);
};

USGSOverlay.prototype.draw = function() {

  // We use the south-west and north-east
  // coordinates of the overlay to peg it to the correct position and size.
  // To do this, we need to retrieve the projection from the overlay.
  var overlayProjection = this.getProjection();

  // Retrieve the south-west and north-east coordinates of this overlay
  // in LatLngs and convert them to pixel coordinates.
  // We'll use these coordinates to resize the div.
  var sw = overlayProjection.fromLatLngToDivPixel(this.bounds_.getSouthWest());
  var ne = overlayProjection.fromLatLngToDivPixel(this.bounds_.getNorthEast());

  // Resize the image's div to fit the indicated dimensions.
  var div = this.div_;
  div.style.left = sw.x + 'px';
  div.style.top = ne.y + 'px';
  div.style.width = (ne.x - sw.x) + 'px';
  div.style.height = (sw.y - ne.y) + 'px';
};

USGSOverlay.prototype.onRemove = function() {
  this.div_.parentNode.removeChild(this.div_);
};

// Set the visibility to 'hidden' or 'visible'.
USGSOverlay.prototype.hide = function() {
  if (this.div_) {
    // The visibility property must be a string enclosed in quotes.
    this.div_.style.visibility = 'hidden';
  }
};

USGSOverlay.prototype.show = function() {
  if (this.div_) {
    this.div_.style.visibility = 'visible';
  }
};

USGSOverlay.prototype.toggle = function() {
  if (this.div_) {
    if (this.div_.style.visibility === 'hidden') {
      this.show();
    } else {
      this.hide();
    }
  }
};

// Detach the map from the DOM via toggleDOM().
// Note that if we later reattach the map, it will be visible again,
// because the containing <div> is recreated in the overlay's onAdd() method.
USGSOverlay.prototype.toggleDOM = function() {
  if (this.getMap()) {
    // Note: setMap(null) calls OverlayView.onRemove()
    this.setMap(null);
  } else {
    this.setMap(this.map_);
  }
};

