    <!-- Sidebar -->
    <aside class="bg-blue-900 w-60 p-6 flex flex-col justify-between">
        <div>
            <div class="mb-12">
                <img src="assets/img/squareLogo.png" alt="Logo" class="w-full h-auto mb-4">
            </div>
            <nav class="space-y-6">
                <a href="?controller=poa&method=index" class="block text-white font-semibold hover:text-gray-200">Inicio</a>
                <a href="?controller=poa&method=myPoas" class="block text-white font-semibold hover:text-gray-200">Mis POA's</a>

                <?php
                    // The executive profile can view area reports and other stuff related 
                    if( in_array( "Ejecutivo", array_column( $_SESSION['userProfiles'], "PROFILE")) ):
                ?>
                    <a href="?controller=poa&method=reports" class="block text-white font-semibold hover:text-gray-200">Reportes</a>
                <?php
                    endif;
                ?>  
                <?php
                    // The editor profile can acces to the administrable part of the system, so that user can add,update or delete base data
                    if( in_array("Editor", array_column( $_SESSION['userProfiles'], "PROFILE") ) ) :                
                ?>
                    <a href="#" class="block text-white font-semibold hover:text-gray-200">Administrar datos</a>
                <?php
                    endif;
                ?>

                <button class="w-full border border-white text-white py-1 hover:bg-blue-800 rounded"><a href='?method=logOut'>Cerrar sesión</a></button>

            </nav>
        </div>
        <!--<div class="mt-6">
            <button class="w-full border border-white text-white py-1 hover:bg-blue-800 rounded"><a href='?method=logOut'>Log Out</a></button>
        </div>-->
    </aside>