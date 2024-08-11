<div class="saved-locations">
    <h2>Saved Locations</h2>
    <?php if (!empty($locations)): ?>
        <table>
            <thead>
            <tr>
                <th>Location Name</th>
                <th>X Coordinate</th>
                <th>Y Coordinate</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($locations as $location): ?>
                <tr>
                    <td><?= htmlspecialchars($location['name'] ?? '') ?></td>
                    <td><?= number_format($location['x_coord'] ?? 0, 6, '.', '') ?></td>
                    <td><?= number_format($location['y_coord'] ?? 0, 6, '.', '') ?></td>
                    <td>
                        <a href="index.php?action=getForecast&id=<?= $location['id'] ?? '' ?>">Get Forecast</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No locations saved yet.</p>
    <?php endif; ?>
</div>