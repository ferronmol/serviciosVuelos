<?php
class UserView
{
    /**
     * Muestra la página de inicio de la aplicación.
     */
    public function showInit()
    {
?>
        <div class="main-container__content mt-3">
            <div class="main-container__content__title">
                <h1 class="animate-character">Ferron Airlines</h1>
            </div>
            <div class="main-container__content__subtitle">
                <h2 class="text txt-white">Take off to the future</h2>
            </div>
            <div class="main-container__content__btn">
                <form action="index.php?controller=User&action=showForm" method="get">
                    <input type="hidden" name="action" value="showForm">
                    <button type="submit" class="btn-entrar" id="btn-entrar"><span>Entrar</span></button>
                </form>
            </div>
        </div>
    <?php
    }
    /**
     * Muestra el formulario de login de acceso a la aplicación.
     * 
     */
    public function showForm()
    {
    ?>
        <div class="main-container__content">
            <div class="main-container__content__title">
                <h3 class="animate-character">ACCOUNT</h3>
            </div>
            <div class="form-container">
                <form action="index.php?controller=User&action=processForm" method="post">
                    <div class="input-group">
                        <label for="nombre">Username</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Enter username" required>
                    </div>;
                    <div class="input-group">
                        <label for="contraseña">Password</label>
                        <input type="password" autocomplete name="contraseña" id="contraseña" placeholder="Password min 6 character" required>
                    </div>
                    <div class="form-container__input">
                        <button type="submit" class="btn-entrar" id="btn-entrar"><span>Login</span></button>
                    </div>
                </form>
            </div>
        </div>
<?php
    }
}
