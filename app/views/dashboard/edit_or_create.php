<?php
include_once __DIR__ . '/../header.php';
include_once __DIR__ . '/../navigationbar.php';
?>

<!-- verbeterd door gpt -->
<div class="container">
    <?php
    $flashHelper->displayFlashMessages();
    ?>
    <h1><?php echo $isEditing ? "Edit" : "Create"; ?><?php echo ucfirst($type); ?></h1>
    <form method="POST" action="<?php echo htmlspecialchars($actionUrl); ?>" enctype="multipart/form-data">
        <input type="hidden" name="type" value="<?php echo htmlspecialchars($type); ?>" tabindex="-1">
        <?php if ($isEditing): ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>" tabindex="-1">
        <?php endif; ?>

        <?php foreach ($entityProperties['fields'] as $field): ?>
            <?php
            $uniqueId = "field_" . htmlspecialchars($field) . "_" . uniqid();

            // Skip slug fields
            if ($field === 'slug') {
                continue;
            }

            // Handle identifier fields as hidden inputs
            if ($field === $entityProperties['identifier']): ?>
                <input type="hidden" name="<?php echo htmlspecialchars($field); ?>"
                       value="<?php echo htmlspecialchars($entityData[$field] ?? ''); ?>" tabindex="-1">


            <?php else: ?>
                <div class="mb-3">
                    <label for="<?= $uniqueId; ?>">
                        <?= htmlspecialchars(ucfirst(str_replace(['Id', '_'], [' ', ' '], $field))); ?>
                    </label>

                    <!-- Determine if field has foreign key options-->
                    <?php if (array_key_exists($field, $foreignKeyOptions)): ?>
                        <select class="form-control" id="<?= $uniqueId; ?>" name="<?= htmlspecialchars($field); ?>">
                            <?php foreach ($foreignKeyOptions[$field] as $option): ?>
                                <?php $selected = (isset($entityData[$field]) && $entityData[$field] == $option[$field]) ? 'selected' : ''; ?>
                                <option value="<?= htmlspecialchars($option[$field]); ?>" <?= $selected; ?>>
                                    <?= htmlspecialchars($option['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Handle image and music files with file input-->
                    <?php elseif (str_contains(strtolower($field), 'image') || (str_contains(strtolower($field), 'music') && !str_contains(strtolower($field), 'id'))):
                        $acceptType = str_contains(strtolower($field), 'image') ? 'image/*' : 'audio/*'; ?>
                        <input type="file" class="form-control" id="<?= $uniqueId; ?>"
                               name="<?= htmlspecialchars($field); ?>" accept="<?= $acceptType; ?>">
                        <?php if ($isEditing && !empty($entityData[$field])): ?>
                        <?php if (str_contains(strtolower($field), 'image')): ?>
                            <img src="<?php echo htmlspecialchars($entityData[$field]); ?>" alt="Currently uploaded"
                                 style="max-width: 100px; max-height: 100px; display: block; margin-top: 10px;">
                        <?php else: ?>
                            <audio controls style="margin-top: 10px;">
                                <source src="<?php echo htmlspecialchars($entityData[$field]); ?>" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php
                    // Handle all other fields with appropriate input types
                    else:
                        // Determine input type based on field name
                        $inputType = 'text';
                        $minAttribute = '';
                        if (str_contains($field, 'Time')) {
                            $inputType = 'datetime-local';
                        } elseif (str_contains(strtolower($field), 'price') || str_contains(strtolower($field), 'amount')) {
                            $inputType = 'number';
                            $minAttribute = 'min="0"';
                        }
                        ?>
                        <input type="<?= $inputType; ?>" class="form-control"
                               id="<?= $uniqueId; ?>"
                               name="<?= htmlspecialchars($field); ?>"
                        <?= $minAttribute; ?>  // Apply min attribute here
                        value="<?= htmlspecialchars_decode($entityData[$field] ?? ''); ?>">
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>


        <div class="row justify-content-center">
            <div class="col-auto mb-3 mr-2">
                <button type="submit" class="btn btn-primary"><?php echo $isEditing ? "Update" : "Create"; ?></button>
            </div>
            <div class="col-auto mb-3 ml-2 ms-4">
                <a href="/manage?type=<?= htmlspecialchars($type); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        // Target both text inputs and textareas, but exclude specific types dynamically
        const textInputs = document.querySelectorAll('input[type="text"]');
        const textareas = document.querySelectorAll('textarea');

        // Function to initialize TinyMCE on an element
        const initTinyMCE = (selector) => {
            tinymce.init({
                target: selector,
                toolbar: 'undo redo | bold italic underline strikethrough',
            });
        };

        textareas.forEach(initTinyMCE);

        textInputs.forEach(input => {
            // Exclude based on the input name or other criteria
            if (!input.name.includes('image') && !input.name.includes('music')) {
                initTinyMCE(input);
            }
        });
    });
</script>


<?php
include_once __DIR__ . '/../footer.php';
?>
