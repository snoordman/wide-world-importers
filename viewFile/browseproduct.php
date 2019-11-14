<!-- Alles met html -->

<div>
    <form action="/action_page.php" id="carform">
        <input type="text" name="fname">
        <br>
        <select name="carlist" form="carform">
            <option value=10>10</option>
            <option value=25>25</option>
            <option value=50>50</option>
            <option value=100>100</option>
        </select>
        <br/>
        <input type="submit">
    </form>

    <p>The drop-down list is outside the form element, but should still be a part of the form.</p>
</div>
