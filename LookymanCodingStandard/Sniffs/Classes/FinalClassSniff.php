<?php

declare(strict_types = 1);

namespace LookymanCodingStandard\Sniffs\Classes;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;
use SlevomatCodingStandard\Helpers\ClassHelper;
use SlevomatCodingStandard\Helpers\SuppressHelper;

final class FinalClassSniff implements Sniff
{

	const NAME = 'LookymanCodingStandard.Classes.FinalClass';

	const CODE_NOT_FINAL_CLASS = 'NotFinalClass';

	/**
	 * @return int[]
	 */
	public function register(): array
	{
		return [
			\T_CLASS,
		];
	}

	/**
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 * @param File $phpcsFile
	 * @param int $stackPtr
	 * @return void
	 */
	public function process(File $phpcsFile, $stackPtr)
	{
		$tokens = $phpcsFile->getTokens();
		if (!\in_array($tokens[$stackPtr - 2]['code'], [\T_ABSTRACT, \T_FINAL])
			&& !SuppressHelper::isSniffSuppressed(
				$phpcsFile,
				$stackPtr,
				\sprintf('%s.%s', self::NAME, self::CODE_NOT_FINAL_CLASS)
			)) {
			$fix = $phpcsFile->addFixableError(
				\sprintf(
					'Concrete class %s is not final.',
					ClassHelper::getFullyQualifiedName($phpcsFile, $stackPtr)
				),
				$stackPtr,
				self::CODE_NOT_FINAL_CLASS
			);
			if ($fix) {
				$phpcsFile->fixer->beginChangeset();
				$phpcsFile->fixer->addContentBefore($stackPtr, 'final ');
				$phpcsFile->fixer->endChangeset();
			}
		}
	}

}
