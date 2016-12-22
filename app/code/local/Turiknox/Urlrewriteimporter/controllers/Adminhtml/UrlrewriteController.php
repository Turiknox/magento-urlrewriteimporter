<?php
require_once Mage::getModuleDir('controllers', 'Mage_Adminhtml') . DS . 'UrlrewriteController.php';
class Turiknox_Urlrewriteimporter_Adminhtml_UrlRewriteController extends Mage_Adminhtml_UrlrewriteController
{
    /**
     * File name
     * @var
     */
    protected $_filename;

    /**
     * Total number of records
     * @var
     */
    protected $_total = 0;

    /**
     * Total numer of records imported
     * @var int
     */
    protected $_totalImported = 0;

    /**
     * Skip headers in import
     * @var
     */
    protected $_skipHeaders = false;

    /**
     * @param $type
     * @return bool
     */
    private function _allowedType($type) {
        $mimes = array(
            'text/csv',
            'text/plain',
            'application/csv',
            'text/comma-separated-values',
            'application/excel',
            'application/vnd.ms-excel',
            'application/vnd.msexcel',
            'text/anytext',
            'application/octet-stream',
            'application/txt',
        );

        if (in_array($type, $mimes)) {
            return true;
        }
        return false;
    }

    /**
     * Import action
     */
    public function importAction()
    {
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('turiknox_urlrewriteimporter/adminhtml_edit'));
        $this->_addLeft($this->getLayout()->createBlock('turiknox_urlrewriteimporter/adminhtml_edit_tabs'));
        $this->_setActiveMenu('catalog/urlrewrite');
        $this->renderLayout();
    }

    /**
     * Save action
     */
    public function processImportAction()
    {
        if ($this->getRequest()->isPost()) {

            $this->_filename = $_FILES['file']['tmp_name'];

            if (!file_exists($this->_filename)) {
                $this->_getSession()->addError('Unable to upload the file!');
                $this->_redirectReferer();
                return;
            }

            if ($this->_allowedType($_FILES['file']['type']) == false) {
                $this->_getSession()->addError('Sorry, this mime type is not allowed.');
                $this->_redirectReferer();
                return;
            }

            $this->_skipHeaders = $this->getRequest()->getParam('skip_headers', false);
            $this->processUrlRewrites();
        }
        $this->_redirect('*/urlrewrite/index');
        return;
    }

    /**
     * Process URL Rewrites
     */
    public function processUrlRewrites()
    {
        if (($fp = fopen($this->_filename, 'r'))) {
            while (($line = fgetcsv($fp))) {
                $this->_total++;
                if ($this->_skipHeaders && ($this->_total == 1)) {
                    continue;
                }

                $storeId = isset($line[0]) ? $line[0] : 0;
                $requestPath = isset($line[1]) ? $line[1] : '';
                $targetPath = isset($line[2]) ? $line[2] : '';
                $redirect = isset($line[3]) ? $line[3] : '';
                $description = isset($line[4]) ? $line[4] : '';

                $rewrite = Mage::getModel('core/url_rewrite');
                $rewrite->setIdPath(uniqid())
                    ->setStoreId($storeId)
                    ->setTargetPath($targetPath)
                    ->setOptions($redirect)
                    ->setDescription($description)
                    ->setRequestPath($requestPath)
                    ->setIsSystem(0);

                try {
                    $rewrite->save();
                    $this->_totalImported++;
                } catch (Exception $e) {
                    $logException = $e->getMessage();
                    Mage::logException($e);
                }
            }

            fclose($fp);
            unlink($this->_filename);

            if ($this->_totalImported === 0) {
                $this->_getSession()->addError('No URL rewrites have been imported.');
                if (!empty($logException)) {
                    $this->_getSession()->addError(sprintf('Import Error: %s', $logException));
                }
                $this->_redirectReferer();
                return;
            } else {
                $this->_getSession()->addSuccess(sprintf('%s URL rewrites have been imported.', $this->_totalImported));
                if (!empty($logException)) {
                    $this->_getSession()->addError(sprintf('Import Error: %s', $logException));
                }
            }
        }
    }
}