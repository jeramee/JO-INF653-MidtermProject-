<!-- ../view/item_list.php --> 
<main>
    <h1>ToDo List</h1>
    <form action="../controller/index.php" method="get">
        <label for="category_id">Select Category:</label>
        <select name="category_id" id="category_id">
            <option value="">All Categories</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['category_id']; ?>" 
                    <?php if ($category['category_id'] == $category_id) echo 'selected'; ?>>
                    <?php echo $category['category_name']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filter</button>
    </form>
    <ul>
        <?php if (isset($toDoItems) && is_array($toDoItems)) : ?>
            <?php foreach ($toDoItems as $item) : ?>
                <li>
                    <?php echo $item['Title']; ?> - <?php echo $item['Description']; ?>
                    (Category: <?php echo isset($item['category_name']) ? $item['category_name'] : 'None'; ?>)
                    <a href='../controller/remove.php?id=<?php echo $item['item_id']; ?>'>Remove</a>                </li>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No to-do list items exist yet.</p>
        <?php endif; ?>
    </ul>
</main>
