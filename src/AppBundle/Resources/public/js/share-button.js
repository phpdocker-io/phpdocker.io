$(initShareButton);
function initShareButton() {
    var shareButton = new ShareButton({
        networks: {
            pinterest: {
                enabled: false
            },
            email: {
                enabled: false
            }
        }
    });

    $('.share').click(function () {
        shareButton.toggle();
    });
}
