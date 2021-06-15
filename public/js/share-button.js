$(initShareButton)

function initShareButton () {
    var shareButton = new ShareButton({
        networks: {
            pinterest: {
                enabled: false
            },
            email: {
                enabled: false
            }
        }
    })

    // This is our custom share link
    $('.share').click(function () {
        shareButton.toggle()
    })
}
