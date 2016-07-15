<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {
	public function indexAction() {
		return new ViewModel ();
	}
	public function cadastrarUsuarioAction() {
		$request = $this->getRequest ();
		$result = array ();
		if ($request->isPost ()) {
			try {
				$nome = $request->getPost ( "nome" );
				$cpf = $request->getPost ( "cpf" );
				$idade = $request->getPost ( "idade" );
				$sexo = $request->getPost ( "sexo" );
				
				if (! empty ( $nome ) && ! empty ( $cpf ) && ! empty ( $idade ) && ! empty ( $sexo )) {
					$usuario = new \Application\Model\Usuario ();
					$usuario->nome = $nome;
					$usuario->cpf = $cpf;
					$usuario->idade = $idade;
					$usuario->sexo = $sexo;
					
					$em = $this->getServiceLocator ()->get ( "Doctrine\ORM\EntityManager" );
					$em->persist ( $usuario );
					$em->flush ();
					
					$result ["resp"] = $nome . ", cadastrado corretamente!";
				} else {
					$result ["resp"] = "Por favor preencher todos os campos";
				}
			} catch ( Exception $e ) {
				$result ["resp"] = "Ocorreu um erro ao cadastrar";
			}
		}
		return new ViewModel ( $result );
	}
	public function cadastrarDoencaAction() {
		$request = $this->getRequest ();
		$result = array ();
		if ($request->isPost ()) {
			try {
				$nome = $request->getPost ( "nome" );
				if (! empty ( $nome )) {
					$doenca = new \Application\Model\Doenca ();
					$doenca->nome = $nome;
					
					$em = $this->getServiceLocator ()->get ( "Doctrine\ORM\EntityManager" );
					$em->persist ( $doenca );
					$em->flush ();
					
					$result ["resp"] = "Doenca " . $nome . " cadastrada corretamente!";
				} else {
					$result ["resp"] = "Por favor preencher o campo nome";
				}
			} catch ( Exception $e ) {
				$result ["resp"] = "Ocorreu um erro ao cadastrar doenca";
			}
		}
		return new ViewModel ( $result );
	}
	public function cadastrarVacinaAction() {
		$request = $this->getRequest ();
		$result = array ();
		$em = $this->getServiceLocator ()->get ( "Doctrine\ORM\EntityManager" );
		$doencaRepo = $em->getRepository ( "Application\Model\Doenca" );
		$lista = $doencaRepo->findAll ();
		$result ["lista"] = $lista;
		if ($request->isPost ()) {
			try {
				$nome = $request->getPost ( "nome" );
				$validade = $request->getPost ( "validade" );
				$idDoenca = $request->getPost ( "id-doenca" );
				if (! empty ( $nome ) && ! empty ( $validade ) && ! empty ( $idDoenca )) {
					$criteria = array (
							"doencaId" => $idDoenca 
					);
					$doenca = $doencaRepo->findOneBy ( $criteria );
					$vacina = new \Application\Model\Vacina ();
					$vacina->nome = $nome;
					$vacina->validade = new \DateTime ( $validade, new \DateTimeZone ( "America/Sao_Paulo" ) );
					$vacina->doenca = $doenca;
					$em->persist ( $vacina );
					$em->flush ();
					$result ["resp"] = "Vacina  " . $nome . "cadastrada corretamente!";
				} else {
					$result ["resp"] = "Por favor preencher todos os campos";
				}
			} catch ( Exception $e ) {
				$result ["resp"] = "Ocorreu um erro ao cadastrar vacina";
			}
		}
		return new ViewModel ( $result );
	}
	public function cadastrarTipoVacinaAction() {
		$request = $this->getRequest ();
		$result = array ();
		$em = $this->getServiceLocator ()->get ( "Doctrine\ORM\EntityManager" );
		$vacinaRepo = $em->getRepository ( "Application\Model\Vacina" );
		$lista = $vacinaRepo->findAll ();
		$result ["lista"] = $lista;
		if ($request->isPost ()) {
			try {
				$nome = $request->getPost ( "nome" );
				$idVacina = $request->getPost ( "id-vacina" );
				if (! empty ( $nome ) && ! empty ( $idVacina )) {
					$criteria = array (
							"vacinaId" => $idVacina 
					);
					$vacina = $vacinaRepo->findOneBy ( $criteria );
					$tipo = new \Application\Model\Tipo();
					$tipo->nomeTipo = $nome;
					$tipo->vacina = $vacina;
					$em->persist ( $tipo );
					$em->flush ();
					$result ["resp"] = "Tipo " . $nome . " cadastrado corretamente!";
				} else {
					$result ["resp"] = "Por favor preencher todos os campos";
				}
			} catch ( Exception $e ) {
				$result ["resp"] = "Ocorreu um erro ao cadastrar o tipo da vacina";
			}
		}
		return new ViewModel ( $result );
	}
	public function associarVacinaAction() {
		$request = $this->getRequest ();
		$result = array ();
		$em = $this->getServiceLocator ()->get ( "Doctrine\ORM\EntityManager" );
		$usuarioRepo = $em->getRepository ( "Application\Model\Usuario" );
		$vacinaRepo = $em->getRepository ( "Application\Model\Vacina" );
		$vacinas = $vacinaRepo->findAll ();
		$usuarios = $usuarioRepo->findAll ();
		$result ["vacinas"] = $vacinas;
		$result ["usuarios"] = $usuarios;
		if ($request->isPost ()) {
			try {
				$idVacina = $request->getPost ( "id-vacina" );
				$idUsuario = $request->getPost ( "id-usuario" );
				if (! empty ( $idVacina ) && ! empty ( $idUsuario )) {
					$criteriaVac = array (
							"vacinaId" => $idVacina
					);
					$criteriaUsuario = array (
							"usuarioId" => $idUsuario
					);
					$vacina = $vacinaRepo->findOneBy ( $criteriaVac );
					$usuario = $usuarioRepo->findOneBy ( $criteriaUsuario );
					$ctv = new \Application\Model\CarteiraDeVacinacao();
					$ctv->usuario = $usuario;
					$ctv->vacina = $vacina;
					$ctv->dataVacinacao = new \DateTime ( "now", new \DateTimeZone ( "America/Sao_Paulo" ) );
					$em->persist ( $ctv );
					$em->flush ();
					$result ["resp"] = "Vacina associada corretamente!";
				} else {
					$result ["resp"] = "Por favor preencher todos os campos";
				}
			} catch ( Exception $e ) {	
				$result ["resp"] = "Ocorreu um erro ao cadastrar o tipo da vacina";
			}
		}
		return new ViewModel ( $result );
	}
	public function criterio1Action() {
		$request = $this->getRequest ();
		$result = array ();
		$em = $this->getServiceLocator ()->get ( "Doctrine\ORM\EntityManager" );
		$usuarioRepo = $em->getRepository ( "Application\Model\Usuario" );
		$ctvRepo = $em->getRepository ( "Application\Model\CarteiraDeVacinacao" );
		$usuarios = $usuarioRepo->findAll ();
		$result ["usuarios"] = $usuarios;
		if ($request->isPost ()) {
			try {
				$idUsuario = $request->getPost ( "id-usuario" );
				$criteriaUsuario = array (
						"usuarioId" => $idUsuario
				);
				if (! empty ( $idUsuario )) {
					$usuario = $usuarioRepo->findOneBy($criteriaUsuario);
					$criteriaCtv = array (
							"usuario" => $usuario
					);
					$vacinas = $ctvRepo->findBy ($criteriaCtv);
					$result ["vacinas"] = $vacinas;
				} else {
					$result ["resp"] = "Por favor selecionar um usuario todos os campos";
				}
			} catch ( \Exception $e ) {
				$result ["resp"] = "Ocorreu um erro ao cadastrar o tipo da vacina";
			}
		}
		return new ViewModel ($result );
	}
	public function criterio2Action() {
		$request = $this->getRequest ();
		$result = array ();
		$em = $this->getServiceLocator ()->get ( "Doctrine\ORM\EntityManager" );
		$usuarioRepo = $em->getRepository ( "Application\Model\Usuario" );
		$ctvRepo = $em->getRepository ( "Application\Model\CarteiraDeVacinacao" );
		$usuarios = $usuarioRepo->findAll ();
		$result ["usuarios"] = $usuarios;
		if ($request->isPost ()) {
			try {
				$idUsuario = $request->getPost ( "id-usuario" );
				$criteriaUsuario = array (
						"usuarioId" => $idUsuario
				);
				if (! empty ( $idUsuario )) {
					$usuario = $usuarioRepo->findOneBy($criteriaUsuario);
					$criteriaCtv = array (
							"usuario" => $usuario
					);
					$vacinas = $ctvRepo->findBy ($criteriaCtv);
					$result ["qtvacinas"] =  count($vacinas);
				} else {
					$result ["resp"] = "Por favor selecionar um usuario todos os campos";
				}
			} catch ( \Exception $e ) {
				$result ["resp"] = "Ocorreu um erro ao cadastrar o tipo da vacina";
			}
		}
		return new ViewModel ($result );
	}
}
