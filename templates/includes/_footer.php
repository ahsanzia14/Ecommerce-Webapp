<!-- footer -->
<footer class="footer-wrapper">
    <section class="footer-main">

        <div class="container">
            <div class="row">

                <div class="col-md-7 col-sm-8">
                    <h4>About Us</h4>
                    <p class="text-justify"><?= Helper::shortenString(htmlspecialchars($business['about']), 150); ?><a href="/?page=about">Read
                            More</a></p>
                </div>
                <div class="visible-xs"><br></div>
                <div class="col-md-offset-1 col-md-4 col-sm-4">
                    <h4>Stay in Touch</h4>
                    <ul class="list-inline">
                        <li><a href="https://www.facebook.com" title="facebook"><i class="fa fa-facebook-official fa-2x"
                                                                                   aria-hidden="true"></i></a></li>
                        <li><a href="https://www.twitter.com" title="twitter"><i class="fa fa-twitter fa-2x"
                                                                                 aria-hidden="true"></i></a></li>
                        <li><a href="https://plus.google.com/" title="google plus"><i
                                    class="fa fa-google-plus-official fa-2x" aria-hidden="true"></i></a></li>
                        <li><a href="https://www.instagram.com" title="instagram"><i class="fa fa-instagram fa-2x"
                                                                                     aria-hidden="true"></i></a></li>
                        <!--                        <li><a href="https://www..com"><i class="fa fa-whatsapp fa-2x" aria-hidden="true"></i></a></li>-->
                        <!--                        <li><a href="#"><i class="fa fa-pinterest fa-2x" aria-hidden="true"></i></a></li>-->

                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="footer-rights">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p><?= htmlspecialchars($business['name']); ?> &copy; All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </section>
</footer>
<!-- /footer -->

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
<script src="/js/jquery-1.12.4.min.js"></script>
<script src="/js/basket.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/js/bootstrap.min.js"></script>
</body>

</html>