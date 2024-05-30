<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';
?>

<!-- Flex container -->
<div class="container-fluid"> <!-- Ensure full width of the viewport -->
    <div class="row"> <!-- Bootstrap row to contain sidebar and main content -->

        <div class="flex-shrink-0 p-3" style="width: 280px;">
            <?php include_once __DIR__ . '/sidebar.php'; ?>
        </div>

        <!-- Main content -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4"> <!-- Adjusted classes for main content -->
            <?php $flashHelper->displayFlashMessages(); ?>

            <div class="row justify-content-between mt-5"> <!-- Bootstrap row for buttons -->
                <div class="col-auto">
                    <a href="/<?php echo htmlspecialchars($entityType); ?>/create" class="btn btn-primary">Create new <?php echo ucfirst(htmlspecialchars($entityType)); ?></a>
                </div>
                <div class="col-auto">
                    <a href="/dashboard" class="btn btn-primary">Back to dashboard</a>
                </div>
            </div>

            <h1><?php echo ucfirst($entityType) . 's'; ?></h1>

            <div class="table-responsive"> <!-- Responsive table wrapper -->
                <table id="sortableTable" class="display table">
                    <caption>
                        This table displays entities with their respective properties and allows for editing and deletion.
                    </caption>
                    <thead>
                    <tr>
                        <?php foreach ($entityProperties['headers'] as $header): ?>
                            <?php if (strtolower($header) !== 'slug'): ?>
                                <th><?php echo $header; ?></th>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($entities as $entity): ?>
                        <tr>
                            <?php foreach ($entityProperties['fields'] as $field): ?>
                                <?php if ($field !== 'slug'): ?>
                                    <td>
                                        <?php
                                        if (str_contains(strtolower($field), 'image')) {
                                            if (!empty($entity[$field])) {
                                                echo '<img src="' . htmlspecialchars($entity[$field]) . '" alt="Image preview" style="width: 100px; height: auto;">';
                                            } else {
                                                echo 'No image';
                                            }
                                        } else {
                                            echo htmlspecialchars_decode($entity[$field] ?? '');
                                        }
                                        ?>
                                    </td>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <td>
                                <?php
                                $identifierColumn = $entityProperties['identifier'] ?? 'id';
                                $editUrl = "/{$entityType}/edit/{$entity[$identifierColumn]}";
                                $deleteUrl = "/{$entityType}/delete/{$entity[$identifierColumn]}";
                                ?>
                                <?php if (isset($entity[$identifierColumn])): ?>
                                    <a href="<?php echo $editUrl; ?>">Edit</a> |
                                    <a href="manage/processDelete?type=<?php echo $entityType; ?>&id=<?php echo $entity[$identifierColumn]; ?>"
                                       onclick="return confirm('Are you sure you want to delete this?');">Delete</a>
                                <?php else: ?>
                                    <span><?php echo ucfirst($entityType) ?> ID Missing</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#sortableTable').DataTable();
    });
</script>

<?php
include_once __DIR__ . '/../footer.php';
?>
