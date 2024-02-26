((Drupal) => {
  Drupal.behaviors.links = {
    attach(context) {
      console.log("testing");
    },
  };
})(Drupal);
