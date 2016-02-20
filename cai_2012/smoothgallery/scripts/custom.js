var myGallery;
function startGallery() {
    myGallery = new gallery($('myGallery'), {
  });
  myGallery.showCarousel();
  myGallery.prepareTimer();
}
window.onDomReady(startGallery);

var toggled=0;
function togglePause() {
  if (toggled==0){
      myGallery.clearTimer();
      toggled=1;
  }
  else {
    myGallery.nextItem();
    toggled=0;
  };
}
