<div id="about">
            <About class="About__container">

                <div class="content__container">
                    <div class="image__container">
                        <img src="poo/1.jpg" alt="Pool Villa Pattaya">
                    </div>
                    <div class="text__container">
                        <h1 class="about-us-title">ABOUT US</h1>
                        <h1 class="villa-title"><?= $villa_about[0]['content']; ?></h1>
                        <p>
                            <?= $villa_about[1]['content']; ?>

                        </p>
                        <div class="highlight__box">
                            <h2> <?= $villa_about[2]['content']; ?></h2>
                            <ul>
                                <li> <?= $villa_about[3]['content']; ?></li>
                                <li> <?= $villa_about[4]['content']; ?></li>
                                <li> <?= $villa_about[5]['content']; ?></li>
                            </ul>

                        </div>
                    </div>
                </div>
        </div>

        <style>
            .About__container {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 5rem 2rem;
                position: relative;
                background-color: hsl(0, 0%, 99%);
            }

            .content__container {
                display: flex;
                max-width: 1200px;
                width: 100%;
                margin: 0 auto;
                gap: 2rem;
                position: relative;
            }

            .image__container {
                flex: 1;
                min-width: 300px;
                position: relative;
            }

            .image__container img {
                width: 100%;
                height: 850px;
               
                object-fit: cover;
                
                border-radius: 10px;
            }

            .text__container {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                
                margin-top: -2rem;
               
            }

            .about-us-title {
                font-size: 5rem;
                
                color: rgba(128, 128, 128, 0.5);
                /* สีเทาจางๆ */
                margin-bottom: 2rem;
                text-align: center;
            }

            .villa-title {
                font-size: 2.5rem;
                color: #000;
                margin-bottom: 1.5rem;
                margin-top: 2rem;
                
            }

            .text__container p {
                font-size: 1.2rem;
                color: #333;
                margin-bottom: 1.5rem;
            }

            .highlight__box {
                background-color: #f7c95c;
                padding: 1.5rem;
                position: absolute;
                top: 45%;
                
                left: 550px;
               
                width: 50%;
                
                z-index: 2;
                
            }

            .highlight__box h2 {
                font-size: 1.8rem;
                margin-bottom: 1rem;
                color: #000;
            }

            .highlight__box ul {
                list-style-type: none;
                padding: 0;
                margin: 0;
            }

            .highlight__box ul li {
                font-size: 1.2rem;
                margin-bottom: 0.5rem;
                color: #000;
            }

            .highlight__box ul li::before {
                content: '✔';
                color: #000;
                margin-right: 0.5rem;
            }

            .highlight__box button {
                background-color: #5dbcd2;
                border: none;
                padding: 0.8rem 1.5rem;
                color: #fff;
                font-size: 1rem;
                border-radius: 5px;
                cursor: pointer;
            }

            .highlight__box button:hover {
                background-color: #499aa8;
            }

           
            .about-us-title {
                font-size: 5rem;
            }

            .villa-title {
                font-size: 2.5rem;
            }

            .text__container p {
                font-size: 1.2rem;
            }

            .highlight__box h2 {
                font-size: 1.8rem;
            }

            .highlight__box ul li {
                font-size: 1.2rem;
            }


            
            @media (max-width: 1024px) {
                .about-us-title {
                    font-size: 4.0rem;
                    
                }

                .about-us-title {
                    font-size: 4rem;
                    
                    color: rgba(128, 128, 128, 0.5);
                    /* สีเทาจางๆ */
                    margin-bottom: 2rem;
                    text-align: center;
                }

                .image__container img {
                    width: 100%;
                    height: 650px;
                  
                    object-fit: cover;
                    
                    border-radius: 10px;
                }

                .highlight__box {
                    background-color: #f7c95c;
                    padding: 1.5rem;
                    position: absolute;
                    top: 55%;
                    
                    left: 400px;
                    
                    width: 50%;
                    
                    z-index: 2;
                    
                }

                .villa-title {
                    font-size: 2.0rem;
                    
                }

                .text__container p {
                    font-size: 1.1rem;
                    
                }
                .highlight__box h2 {
                    font-size: 1.3rem;
                    
                }

                .highlight__box ul li {
                    font-size: 1.0rem;
                   
                }
            }

            
            @media (max-width: 769px) {
                .about-us-title {
                    font-size: 4rem;
                    
                }

                .about-us-title {
                    font-size: 3rem;
                   
                    color: rgba(128, 128, 128, 0.5);
                   
                    margin-bottom: 2rem;
                    text-align: center;
                }

                .villa-title {
                    font-size: 2rem;
                    color: #000;
                    margin-bottom: 1.5rem;
                    margin-top: 2rem;
                    
                }

                .highlight__box {
                    background-color: #f7c95c;
                    padding: 1.5rem;
                    position: absolute;
                    top: 55%;
                  
                    left: 250px;
                   
                    width: 50%;
                    
                    z-index: 2;
                   
                }
                .image__container img {
                    width: 100%;
                    height: 650px;
                    
                    object-fit: cover;
                    
                    border-radius: 10px;
                }

                .villa-title {
                    font-size: 2rem;
                   
                }

                .text__container p {
                    font-size: 1rem;
                  
                }

                .highlight__box h2 {
                    font-size: 1.2rem;
                    
                }

                .highlight__box ul li {
                    font-size: 1rem;
                   
                }
            }

            
            @media (max-width: 480px) {
                .About__container {
                    display: none;
                }

                .about-us-title {
                    font-size: 4.1rem;
                   
                }

                .villa-title {
                    font-size: 1.7rem;
                    
                }

                .text__container p {
                    font-size: 0.9rem;
                   
                }

                .highlight__box h2 {
                    font-size: 1rem;
                   
                }

                .highlight__box ul li {
                    font-size: 0.9rem;
                    
                }
            }
        </style>
        </About>
