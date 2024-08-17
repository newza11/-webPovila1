<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "my_website";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ดึงข้อมูลจากตาราง villa_home_content
$sql_home_content = "SELECT title, description ,image_path FROM villa_home_content "; // ปรับ WHERE ตามต้องการ
$result_home_content = $conn->query($sql_home_content);

if ($result_home_content->num_rows > 0) {
  while ($row = $result_home_content->fetch_assoc()) {
    $villa_home[] = $row;
    
    
    }
}



// ดึงข้อมูลจากตาราง villa_details
$sql_villa_details = "SELECT detail_type, detail_description FROM villa_details  ";
$result_villa_details = $conn->query($sql_villa_details);

if ($result_villa_details->num_rows > 0) {
    

    $villaDetails = [];
    while ($row = $result_villa_details->fetch_assoc()) {
        $villaDetails[] = $row; // เก็บข้อมูลแต่ละแถวเป็นอาร์เรย์ใน $villaDetails
        

        
    }
  }

  $sql_accordion_items = "SELECT id, title, description ,image_path FROM accordion_items";
  $result_accordion_items = $conn->query($sql_accordion_items);
  
  $accordionItems = [];
  if ($result_accordion_items->num_rows > 0) {
      while ($row = $result_accordion_items->fetch_assoc()) {
          $accordionItems[] = $row; // เก็บข้อมูลแต่ละแถวเป็นอาร์เรย์ใน $accordionItems
      }
  }

  
  $sql_villa_images = "SELECT id, image_path FROM villa_images";
$result_villa_images = $conn->query($sql_villa_images);

$villaImages = [];
if ($result_villa_images->num_rows > 0) {
    while ($row = $result_villa_images->fetch_assoc()) {
        $villaImages[] = $row; // เก็บข้อมูลแต่ละแถวเป็นอาร์เรย์ใน $villaImages
    }
}
  
 
  

$conn->close();
?>





<div class="container" style="margin-top: 4rem;" >
      <div class="d-flex flex-column align-items-center" id="list-title">
        <h1>นันท์นภัส</h1>
        <h2>นันท์นภัส พลูวิลล่า อัมพวา</h2>
      </div>
    </div>
    <!-- tabel -->
    <div class="container" style="margin-bottom: 7rem;">
      <div id="list-tab" role="tablist">
        <a
          class="active"
          id="list-home-list"
          data-bs-toggle="list"
          href="#list-home"
          role="tab"
          aria-controls="list-home"
          >แนวคิด</a
        >
        <a
          id="list-profile-list"
          data-bs-toggle="list"
          href="#list-profile"
          role="tab"
          aria-controls="list-profile"
          >ข้อมูลโครงการ</a
        >
        <a
          id="list-messages-list"
          data-bs-toggle="list"
          href="#list-messages"
          role="tab"
          aria-controls="list-messages"
          >สิ่งอำนวยความสะดวก</a
        >
        <a
          id="list-settings-list"
          data-bs-toggle="list"
          href="#list-settings"
          role="tab"
          aria-controls="list-settings"
          >อัลบั้มภาพ</a
        >
      </div>
      <div class="tab-content" id="list-tab-content">
        <div
          class="tab-pane fade show active"
          id="list-home"
          role="tabpanel"
          aria-labelledby="list-home-list"
        >
          <div
            id="list-home-carousel"
            class="carousel slide"
            data-bs-ride="carousel"
            data-bs-interval="5000"
          >
            <div class="carousel-item active">
              <img
                class="d-block"
                src=<?= $villa_home[0]['image_path']; ?>
                alt=""
              />
            </div>
            <div class="carousel-item">
              <img
                class="d-block"
                src=<?= $villa_home[1]['image_path']; ?>
                alt=""
              />
            </div>
            <div class="carousel-item">
              <img
                class="d-block"
                src=<?= $villa_home[2]['image_path']; ?>
                alt=""
              />
            </div>
            <div class="carousel-item">
              <img
                class="d-block"
                src=<?= $villa_home[3]['image_path']; ?>
            alt=""
              />
            </div>
            <div class="carousel-item">
              <img
                class="d-block"
                src=<?= $villa_home[4]['image_path']; ?>
                alt=""
              />
            </div>
            <div class="carousel-item">
              <img
                class="d-block"
                src=<?= $villa_home[5]['image_path']; ?>
                alt=""
              />
            </div>
          </div>
          
          <div class="text">
            <h1><?= $villa_home[0]['title']; ?></h1>
            <p>
            <?= $villa_home[0]['description']; ?>
            
            </p>
          </div>
        </div>
        <div
          class="tab-pane fade"
          id="list-profile"
          role="tabpanel"
          aria-labelledby="list-profile-list"
        >
          <div class="container">
            <div class="row row-cols-2 g-4">
              <div class="col">
                <div class="profile">
                  <img
                    src="https://img.icons8.com/?size=100&id=pmzH4rF8Lrv9&format=png&color=000000"
                    alt=""
                  />
                  <div>
                    <h1><?= $villaDetails[0]['detail_type']; ?></h1>
                    <h2>
                    <?= $villaDetails[0]['detail_description']; ?>
                    </h2>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="profile">
                  <img
                  src="https://img.icons8.com/?size=100&id=hI8Z5yfrLcE0&format=png&color=FA5252"
                  alt=""
                  />
                  <div>
                 <h1><?= $villaDetails[1]['detail_type']; ?></h1>
                    <h2>
                    <?= $villaDetails[1]['detail_description']; ?>
                    </h2>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="profile">
                  <img
                    src="https://img.icons8.com/?size=100&id=A2sfeYasHHVe&format=png&color=FA5252"
                    alt=""
                  />
                  <div>
                  <h1><?= $villaDetails[2]['detail_type']; ?></h1>
                    <h2>
                    <?= $villaDetails[2]['detail_description']; ?>
                    </h2>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="profile">
                  <img
                    src="https://img.icons8.com/?size=100&id=Rsp0d6pd4OhI&format=png&color=FA5252"
                    alt=""
                  />
                  <div>
                  <h1><?= $villaDetails[3]['detail_type']; ?></h1>
                  <h2>
                    <?= $villaDetails[3]['detail_description']; ?>
                    </h2>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="profile">
                  <img
                    src="https://img.icons8.com/?size=100&id=hBLJ3gyryh7v&format=png&color=FA5252"
                    alt=""
                  />
                  <div>
                  <h1><?= $villaDetails[4]['detail_type']; ?></h1>
                  <h2>
                    <?= $villaDetails[4]['detail_description']; ?>
                    </h2>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="profile">
                  <img
                  src="https://img.icons8.com/?size=100&id=nDPYKSLarmGI&format=png&color=FA5252"
                  alt=""
                  />
                  <div>
                  <h1><?= $villaDetails[5]['detail_type']; ?></h1>
                  <h2>
                    <?= $villaDetails[5]['detail_description']; ?>
                    </h2>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <div
          class="tab-pane fade"
          id="list-messages"
          role="tabpanel"
          aria-labelledby="list-messages-list">
        <div class="accordion" id="accordion-list">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button
                class="accordion-button"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseOne"
                aria-expanded="true"
                aria-controls="collapseOne"
              >
              <?= $accordionItems[0]['title']; ?>
              </button>
            </h2>
            <div
              id="collapseOne"
              class="accordion-collapse collapse show"
              aria-labelledby="headingOne"
              data-bs-parent="#accordion-list"
            >
              <div class="accordion-body">
                <?= $accordionItems[0]['description']; ?>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseTwo"
                aria-expanded="false"
                aria-controls="collapseTwo"
              >
              <?= $accordionItems[1]['title']; ?>
              </button>
            </h2>
            <div
              id="collapseTwo"
              class="accordion-collapse collapse"
              aria-labelledby="headingTwo"
              data-bs-parent="#accordion-list"
            >
              <div class="accordion-body">
              <?= $accordionItems[1]['description']; ?>
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseThree"
                aria-expanded="false"
                aria-controls="collapseThree"
              >
              <?= $accordionItems[2]['title']; ?>
              </button>
            </h2>
            <div
              id="collapseThree"
              class="accordion-collapse collapse"
              aria-labelledby="headingThree"
              data-bs-parent="#accordion-list"
            >
              <div class="accordion-body">
              <?= $accordionItems[2]['description']; ?>
              </div>
            </div>
          </div>
        </div>
        
        <div>
          <img
            id="image-display"
            
            src=<?= $accordionItems[0]['image_path']; ?>
            alt=""
          />
        </div>
      </div>
    <div
        class="tab-pane fade"
        id="list-settings"
        role="tabpanel"
        aria-labelledby="list-settings-list"
      >
        <div class="container-fluid img-grid">
          <!-- Main Image -->
          <div>
            <img
            src=<?= $villaImages[0]['image_path']; ?>
              class="img-fluid Main_image"
              
              style="height: 508px"
              alt="Main Image"
              data-bs-toggle="modal"
              data-bs-target="#imageModal"
              data-bs-image="0"
            />
          </div>
          <!-- Side Images -->
          <div class="d-flex flex-column">
            <img
            src=<?= $villaImages[1]['image_path']; ?>
              class="img-fluid mb-2"
              alt="Image 2"
              data-bs-toggle="modal"
              data-bs-target="#imageModal"
              data-bs-image="1"
            />
            <img
            src=<?= $villaImages[2]['image_path']; ?>
              class="img-fluid mb-2"
              alt="Image 3"
              data-bs-toggle="modal"
              data-bs-target="#imageModal"
              data-bs-image="2"
            />
          </div>
          <div class="d-flex flex-column">
            <img
            src=<?= $villaImages[3]['image_path']; ?>
              class="img-fluid mb-2"
              alt="Image 4"
              data-bs-toggle="modal"
              data-bs-target="#imageModal"
              data-bs-image="3"
            />
            <img
            src=<?= $villaImages[4]['image_path']; ?>
              class="img-fluid mb-2"
              alt="Image 5"
              data-bs-toggle="modal"
              data-bs-target="#imageModal"
              data-bs-image="4"
            />
          </div>
        </div>
        </div>
      </div>
    </div>

    <!-- Modal Structure -->
    <div
      class="modal fade"
      id="imageModal"
      tabindex="-1"
      aria-labelledby="imageModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="imageModalLabel">รูปภาพ</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            >
              <img
                src="https://img.icons8.com/?size=100&id=8112&format=png&color=FFFFFF"
                alt="Close"
                class="icon"
              />
            </button>
          </div>
          <div
            class="modal-body p-0 d-flex align-items-center justify-content-center position-relative"
          >
            <img
              id="modalImage"
              src=""
              class="img-fluid"
              alt="Modal Image"
              style="max-width: 100%; max-height: 90vh"
            />
            <button
              class="carousel-control-prev"
              type="button"
              onclick="prevImage()"
            >
              <img
                src="https://img.icons8.com/ios-glyphs/30/ffffff/chevron-left.png"
                alt="Previous"
                class="icon"
              />
            </button>
            <button
              class="carousel-control-next"
              type="button"
              onclick="nextImage()"
            >
              <img
                src="https://img.icons8.com/ios-glyphs/30/ffffff/chevron-right.png"
                alt="Next"
                class="icon"
              />
            </button>
          </div>
          <div class="modal-footer">
            <div
              class="preview-images d-flex justify-content-start"
              id="imageFooter"
            ></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <script>
      const images = [
        "poo/1.jpg",
        "poo/2.jpg",
        "poo/3.jpg",
        "poo/4.jpg",
        "poo/5.jpg",
        "poo/6.jpg",
        "poo/7.jpg",
        "poo/8.jpg",
        "poo/9.jpg",
        "poo/10.jpg",
        "poo/11.jpg",
        "poo/12.jpg",
        "poo/13.jpg",
        "poo/14.jpg",
        "poo/15.jpg",
        "poo/16.jpg",
        "poo/17.jpg",
        "poo/18.jpg",
        "poo/19.jpg",
        "poo/20.jpg",
        "poo/21.jpg",
        "poo/22.jpg",
        "poo/23.jpg",
      ];

      let currentImageIndex = 0;

      function showImage(index) {
        currentImageIndex = index;
        document.getElementById("modalImage").src = images[index];
        centerFooterImage(index);
        highlightCurrentThumbnail(index);
      }

      function prevImage() {
        currentImageIndex =
          (currentImageIndex - 1 + images.length) % images.length;
        showImage(currentImageIndex);
      }

      function nextImage() {
        currentImageIndex = (currentImageIndex + 1) % images.length;
        showImage(currentImageIndex);
      }

      function centerFooterImage(index) {
        const footer = document.getElementById("imageFooter");
        const thumbnails = footer.getElementsByClassName("footer-thumbnail");
        const thumbnailWidth = thumbnails[index].offsetWidth;
        const scrollPosition =
          thumbnails[index].offsetLeft -
          footer.offsetWidth / 2 +
          thumbnailWidth / 2;
        footer.scrollTo({
          left: scrollPosition,
          behavior: "smooth",
        });
      }

      function highlightCurrentThumbnail(index) {
        const thumbnails = document.querySelectorAll(".footer-thumbnail");
        thumbnails.forEach((thumbnail, i) => {
          if (i === index) {
            thumbnail.classList.add("active-thumbnail");
          } else {
            thumbnail.classList.remove("active-thumbnail");
          }
        });
      }

      function addFooterImages() {
        const imageFooter = document.getElementById("imageFooter");
        images.forEach((image, index) => {
          const img = document.createElement("img");
          img.src = image;
          img.classList.add("img-thumbnail", "footer-thumbnail");
          img.setAttribute("onclick", `showImage(${index})`);
          imageFooter.appendChild(img);
        });
      }

      document.addEventListener("DOMContentLoaded", () => {
        addFooterImages();
        showImage(0); // Display the first image by default
      });
    </script>


    <!-- Fix Accordion -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Attach click event listeners to the accordion buttons
        var imagePaths = [
                "<?= htmlspecialchars($accordionItems[0]['image_path']); ?>",
                "<?= htmlspecialchars($accordionItems[1]['image_path']); ?>",
                "<?= htmlspecialchars($accordionItems[2]['image_path']); ?>"
            ];
        document
          .getElementById("headingOne")
          .addEventListener("click", function () {
            document.getElementById("image-display").src = imagePaths[0];
          });
        document
          .getElementById("headingTwo")
          .addEventListener("click", function () {
            document.getElementById("image-display").src = imagePaths[1];
          });
        document
          .getElementById("headingThree")
          .addEventListener("click", function () {
            document.getElementById("image-display").src = imagePaths[2];
          });

        const accordions = document.querySelectorAll(".accordion-collapse");
        let opening = false;
        accordions.forEach(function (element) {
          element.addEventListener("hide.bs.collapse", (event) => {
            if (!opening) {
              event.preventDefault();
              // event.stopPropagation();
            } else {
              opening = false;
            }
          });
          element.addEventListener("show.bs.collapse", (event) => {
            opening = true;
            accordions.forEach(function (otherElement) {
              if (otherElement !== element) {
                const otherCollapse =
                  bootstrap.Collapse.getInstance(otherElement);
                if (otherCollapse) {
                  otherCollapse.hide();
                }
              }
            });
          });
        });
      });
    </script>

    <!-- Modal Script gallary img-->
    <script>
      const imageModal = document.getElementById("imageModal");
      imageModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const imageSrc = button.getAttribute("data-bs-image");
        showImage(parseInt(imageSrc));
      });
    </script>