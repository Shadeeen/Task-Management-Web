<?php
session_start();
include("db.php.inc.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Client_page</title>
    <link rel="icon" type="image/jpg" href="logo.jpg">
</head>

<body>
    <?php if ($_SESSION['role'] == 'Manager') {
        include('managerMenu.html');
    }
    if ($_SESSION['role'] == 'Project-Leader') {
        include('leaderMenu.html');
    }

    if ($_SESSION['role'] == 'Team-Member') {
        include('managerMenu.html');
    } ?>

    <main>
        <article>
            <h2>some information about us:</h2>
            <section>
                <h4>our company:</h4>
                <p> We are a well-known company in the field of technology. Established in 2016, we have been a strong
                    competitor in the market ever since. We consider our customers as part of our family, and our
                    primary
                    goal
                    is to help them and make them happy. </p>
            </section>
            <section>
                <h4>We offer a wide range of services, the most important of
                    which include:</h4>
                <ul>
                    <li> <u><strong> development </strong></u>
                        <figure>
                            <figcaption>
                                <p>Software development refers to a set of computer science activities that are
                                    dedicated to
                                    the
                                    process of creating, designing, deploying, and supporting software</p>
                            </figcaption>
                            <img class="m" src="image/sw.jpg" alt="SW pic">
                        </figure>
                    </li>


                    <li><u><strong>website design</strong></u>
                        <figure>
                            <figcaption>
                                <p>Web design refers to the design of websites. It usually refers to the user experience
                                    aspects of
                                    website development rather than software development.</p>
                            </figcaption>
                            <img class="m" src="image/design.jpg" alt="design pic">
                        </figure>
                    </li>


                    <li><u><Strong>Technical Consulting</strong></u>
                        <figure>
                            <figcaption>
                                <p> An IT Consultant is a knowledgeable professional who helps businesses develop,
                                    integrate, and
                                    maximize the value of IT systems. They provide strategic advice, troubleshoot
                                    technical
                                    issues,
                                    and offer expertise in areas such as hardware, software, networks, and project
                                    management</p>
                            </figcaption>
                            <img class="m" src="image/con.jpg" alt="Consulting pic">
                        </figure>
                    </li>
                </ul>
            </section>

            <section>
                <h4>Customers and suppliers: </h4>
                <p>
                    Our clients and suppliers form the backbone of our business network,
                    underscoring our commitment to delivering high-quality services and building valuable partnerships.
                    We
                    are proud to collaborate with industry leaders such as Alpha Corp and Beta Ltd., who trust us to
                    support
                    their unique needs with innovative solutions and exceptional reliability. These partnerships not
                    only
                    reflect our dedication to quality but also position us as a trusted and capable provider within our
                    industry. By featuring our esteemed clients and suppliers on our homepage, we aim to communicate our
                    extensive experience and network, offering potential clients confidence in our services and
                    assurance of
                    our established reputation. Through these alliances, we continuously strive to enhance our
                    capabilities
                    and deliver unmatched value to those we serve.
                </p>
                <br><br>

                <img class="m" src="image/tec.png" alt="picture">
                <img class="m" src="image/tec2.jpg" alt="picture" height="160">
                <img class="m" src="image/tec3.jpg" alt="picture">


            </section>
        </article>
    </main>

    <footer>
        <p>Contact us on <a href="tel:+97224568466">+972 2 456 8466</a> | <a href="mailto:TAP.company@gmail.com">TAP.company@gmail.com</a></p>
        <p>©2024 Shadeen Hassan Hamda - ID 1220169 | <a href="aboutUs.php">About Us</a></p>
    </footer>

</body>

</html>