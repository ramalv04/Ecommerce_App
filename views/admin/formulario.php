<!-- Template del formulario para crear y actualizar productos -->
<fieldset class="form-fieldset">
    <label for="nombre" class="form-label">Nombre del producto:</label><br>
    <input 
    type="text" 
    id="nombre" 
    name="producto[nombre]"
    placeholder="Nombre"
    value="<?php echo s($producto->nombre); ?>"
    class="form-input">
    <br>

    <label for="precio" class="form-label">Precio:</label><br>
    <input 
    type="number" 
    id="precio" 
    name="producto[precio]" 
    step="0.01"
    placeholder="Precio"
    value="<?php echo s($producto->precio); ?>"
    class="form-input">
    <br>

    <label for="imagen" class="form-label">Imagen:</label><br>
    <input 
    type="file" 
    id="imagen" 
    name="producto[imagen]"
    accept="image/jpeg, image/png"
    class="form-input">
    <br>

    <!-- Muestra la imagen seleccionada una vez creado un producto, o al momento de actualizar uno -->
    <?php if($producto->imagen): ?>
        <img src="/imagenes/<?php echo $producto->imagen; ?>" class="imagen-small">
    <?php endif; ?>

    <label for="descripcion">Descripcion:</label>
    <textarea id="descripcion" name="producto[descripcion]"><?php echo s($producto->descripcion); ?></textarea>

    <label for="categoria" class="form-label">Categoria</label>
    <select name="producto[idCategoria]" id="categoria" class="form-select">
        <option value="" disabled selected>-- Seleccione --</option>
        <!-- Se crea un option por cada categoria que haya disponible -->
        <?php foreach($categorias as $categoria) { ?>
            <option 
            <?php echo $producto->idCategoria === $categoria->id ? 'selected' : ''; ?>
            value="<?php echo s($categoria->id); ?>"
            class="form-option"> 
            <?php echo s($categoria->nombre); ?> </option>
        <?php } ?>
    </select>
</fieldset>