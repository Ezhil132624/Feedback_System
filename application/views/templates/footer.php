   </div> <!-- end content-area -->
   </div> <!-- end flex container -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <div id="overlay"></div>
   </div> <!-- end content-area -->
   </div> <!-- end flex container -->

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <script>
       const toggleBtn = document.getElementById('menu-toggle');
       const sidebar = document.getElementById('sidebar');
       const overlay = document.getElementById('overlay');

       toggleBtn.addEventListener('click', () => {
           sidebar.classList.toggle('show');
           overlay.classList.toggle('show');
       });

       overlay.addEventListener('click', () => {
           sidebar.classList.remove('show');
           overlay.classList.remove('show');
       });
   </script>
   >
   </body>

   </html>