				<div class="form-group">	
					<label for="cod_prato">Prato:</label><br>
					<select name="cod_prato" id="cod_prato" class="form-control" >
						<option value=''>Selecione um prato</option>
						<?php
							$r = $pdo->query("select * from pratos order by descricao");		
							while($d = $r->fetch(PDO::FETCH_ASSOC)) 
							{								
								echo "<option value='$d[cod_prato]'  $s > $d[descricao] </option>";
							}
						?>
					</select>
					<div id="div_erro_cod_prato"></div>
				</div>

				<div class="form-group">	
					<label for="qde">Quantidade:</label><br>
					<input type="text" name="qde" id="qde" maxlength="100" class="form-control"  placeholder="Quantidade do ingrediente">
					<div id="div_erro_qde"></div>
				</div>

				<a href="javascript:incluir_itens_encomenda(<?php echo $num_encomenda; ?>);"  class="btn btn-success">Incluir</a>
				<p></p>
