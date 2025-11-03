
<div class="container fluid">
    <div class="row">
        <table class="table table-hover" id="showPoasTable">
            <thead class="table-dark text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Descripción general
                </th>
                <th scope="col" class="px-6 py-3">
                    Fecha
                </th>
                <th scope="col" class="px-6 py-3">
                    Ejercicio Fiscal
                </th>
                <th scope="col" class="px-6 py-3">
                    Estatus
                </th>
                <!--<th scope="col" class="px-6 py-3">
                    <span class="sr-only"></span>
                </th>-->
                <th scope="col" class="px-6 py-3">
                    <span class="sr-only"></span>
                </th>
            </tr>
            </thead>
            <tbody>
                <?php
                    // Loop through the myPoas array in order to show every poa data
                    foreach( $myPoas as $poa ):
                        $poaId = $poa['ID'];
                        $status = $poa['STATUS'];
                        $productionDate = $poa['PRODUCTIONDATE'];
                        $generalDescription = $poa['GENERALDESCRIPTION'];
                        $fiscalYear = $poa['FISCALYEAR'];
                        $statusId = $poa['STATUSID'];

                        switch( $statusId ):
                            case 1:
                                // Color for the on hold status ( espera )
                                $statusClass = "info";
                            break;
                            case 2:
                                // Color for the aproved status ( aprobado )
                                $statusClass = "success";
                            break;
                            case 3:
                                // Color for the declined status ( declinado )
                                $statusClass = "warning";
                            break;
                            case 4:
                                // Color for the cancel status ( cancelado )
                                $statusClass = "danger";
                            break;
                            case 5:
                                // Color for the finished status ( ejecutado )
                                $statusClass = "primary";
                            break;

                        endswitch;
                ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                            <?= $generalDescription ?>
                        </th>
                        <td class="px-6 py-4">
                            <?= $productionDate ?>
                        </td>
                        <td class="px-6 py-4">
                            <?= $fiscalYear ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="badge text-bg-<?=$statusClass?>" style="color:white" ><?= $status ?></span>
                        </td>
                        <!-- <td class="px-6 py-4 text-right">
                            <button type="button" class="btn btn-info"><i class="fas fa-eye"></i></button>
                        </td>-->
                        <td class="px-6 py-4 text-right">
                            <button type="button" class="btn btn-success btnGeneratePoaExcel" data-poaid= "<?=$poaId?>"><i class="fas fa-file-excel"></i></button>
                        </td>
                    </tr>
                <?php
                    endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>