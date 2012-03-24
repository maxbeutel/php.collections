<?php

namespace Collection\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use InvalidArgumentException;
use RuntimeException;

class TypedCollectionGenerator extends Command
{
	protected function configure()
	{
		$this
			->setName('collection:typed-generator')
			->setDefinition($this->createDefinition())
			->setDescription('Generate typed collection classes based on definitions file')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$definitionsFile = $input->getArgument('definitions');

		if (!file_exists($definitionsFile)) {
			throw new InvalidArgumentException('Definitions file does not exist');
		}

		$definitions = json_decode(file_get_contents($definitionsFile), true);

		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new RuntimeException('Error parsing definitions file');
		}

		$out = '<?php ' . PHP_EOL;

		foreach ($definitions as $fullTypedCollectionClassName => $definition) {
			$typedCollectionNamespace = substr($fullTypedCollectionClassName, 0, strrpos($fullTypedCollectionClassName, '\\')); 
			$typedCollectionClassName = substr(strrchr($fullTypedCollectionClassName, '\\'), 1);

			$collectionTemplate = realpath(__DIR__ . sprintf('/../Typed/%s.php', $definition['base']));

			if (!$collectionTemplate) {
				throw new RuntimeException('Cant find base collection template');
			}

			$templateContent = file_get_contents($collectionTemplate);
			$templateContent = str_replace(
				['{{ namespace }}', '{{ className }}', '{{ typeName }}'],
				[$typedCollectionNamespace, $typedCollectionClassName, $definition['type']],
				$templateContent
			);

			$out .= $templateContent . PHP_EOL;
		}

		$out = trim($out);

		$output->writeln($out);
	}

	private function createDefinition()
	{
		return new InputDefinition(array(
			new InputArgument('definitions', InputArgument::REQUIRED, 'Definitions file'),
		));
	}	
}