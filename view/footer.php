<!-- /view/footer.php -->

</main>

    <!-- Additional links -->
    <!-- Additional links -->
    <p><a href="http://localhost/JO-INF653-MidtermProject/JO-INF655-MidtermProject-/index.php">View Full Vehicle List</a></p>
    <p><a href="http://localhost/JO-INF653-MidtermProject/JO-INF655-MidtermProject-/view/manage_makes_view.php">View Vehicle Makes</a></p>
    <p><a href="http://localhost/JO-INF653-MidtermProject/JO-INF655-MidtermProject-/view/manage_types_view.php">View/Edit Vehicle Types</a></p>
    <p><a href="http://localhost/JO-INF653-MidtermProject/JO-INF655-MidtermProject-/view/manage_classes_view.php">View/Edit Vehicle Classes</a></p>
    </div>



        <script>
            // JavaScript to redirect to manage_classes_view.php with the selected class, type, and make
            document.getElementById('classSelect').addEventListener('change', function() {
                var selectedClass = this.value;
                var selectedType = document.getElementById('typeSelect').value;
                var selectedMake = document.getElementById('makeSelect').value;
                // Redirect to the correct location: view/manage_classes_view.php with the selected parameters
                window.location.href = '../view/manage_classes_view.php?class=' + encodeURIComponent(selectedClass) + '&type=' + encodeURIComponent(selectedType) + '&make=' + encodeURIComponent(selectedMake);
            });

            // JavaScript to redirect to manage_types_view.php with the selected type, class, and make
            document.getElementById('typeSelect').addEventListener('change', function() {
                var selectedType = this.value;
                var selectedClass = document.getElementById('classSelect').value;
                var selectedMake = document.getElementById('makeSelect').value;
                // Redirect to the correct location: view/manage_types_view.php with the selected parameters
                window.location.href = '../view/manage_types_view.php?type=' + encodeURIComponent(selectedType) + '&class=' + encodeURIComponent(selectedClass) + '&make=' + encodeURIComponent(selectedMake);
            });


            // JavaScript to redirect to manage_makes_view.php with the selected make, class, and type
            document.getElementById('makeSelect').addEventListener('change', function() {
                var selectedMake = this.value;
                var selectedClass = document.getElementById('classSelect').value;
                var selectedType = document.getElementById('typeSelect').value;
                // Redirect to the correct location: view/manage_makes_view.php with the selected parameters
                window.location.href = '../view/manage_makes_view.php?make=' + encodeURIComponent(selectedMake) + '&class=' + encodeURIComponent(selectedClass) + '&type=' + encodeURIComponent(selectedType);
            });
        </script>
    <br><br>
    <br><br>
    <br><br>
</body>
    <footer>
        <p>© <?php echo date('Y'); ?> Zippy Used Autos</p>
    </footer>
</html>