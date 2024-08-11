<div class="form-group">
    <h2>Add New Location</h2>
    <form action="index.php?action=addLocation" method="post">
        <label for="x_coord">X Coordinate:</label>
        <input type="number" step="any" id="x_coord" name="x_coord" required>

        <label for="y_coord">Y Coordinate:</label>
        <input type="number" step="any" id="y_coord" name="y_coord" required>

        <label for="location_name">Location Name:</label>
        <input type="text" id="location_name" name="location_name" required>

        <button type="submit">Add Location</button>
    </form>
</div>