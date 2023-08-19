<?php
declare(strict_types=1);

namespace Kanow\Operations\Widgets;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\View\BackendViewFactory;
use TYPO3\CMS\Dashboard\Widgets\AdditionalCssInterface;
use TYPO3\CMS\Dashboard\Widgets\ButtonProviderInterface;
use TYPO3\CMS\Dashboard\Widgets\RequestAwareWidgetInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetConfigurationInterface;
use TYPO3\CMS\Dashboard\Widgets\WidgetInterface;

/**
 * Widget configuration for widgets displaying a list of records
 *
 * @author Karsten Nowak <captnnowi@gmx.de>
 */
class ListOfRecordsWidget implements WidgetInterface, AdditionalCssInterface, RequestAwareWidgetInterface
{
    protected ServerRequestInterface $request;

    public function __construct(
        protected readonly WidgetConfigurationInterface $configuration,
        protected readonly ListOfRecordsDataProviderInterface $dataProvider,
        protected readonly BackendViewFactory $backendViewFactory,
        protected readonly ?ButtonProviderInterface $buttonProvider = null,
        protected array $options = []
    ) {
    }

    public function renderWidgetContent(): string
    {
        $recordTable = $this->dataProvider->getTable();

        if (!($this->options['titleField'] ?? false)) {
            $this->options['titleField'] = $GLOBALS['TCA'][$recordTable]['ctrl']['label'] ?? '';
        }

        return $this->backendViewFactory
            ->create($this->request, ['typo3/cms-dashboard', 'kanow/operations'])
            ->assignMultiple([
                'configuration' => $this->configuration,
                'records' => $this->dataProvider->getItems(),
                'table' => $recordTable,
                'button' => $this->buttonProvider,
                'options' => $this->options
            ])
            ->render('Widget/OperationsListOfRecordsWidget');
    }

    public function getCssFiles(): array
    {
        return ['EXT:operations/Resources/Public/Css/Backend/ListOfOperations.css'];
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }
}
