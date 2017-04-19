<?php

declare(strict_types = 1);

namespace LookymanCodingStandard\Sniffs\Classes;

use SlevomatCodingStandard\Helpers\ClassHelper;
use SlevomatCodingStandard\Helpers\SuppressHelper;

final class FinalClassSniff implements \PHP_CodeSniffer_Sniff
{

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
	 * @param \PHP_CodeSniffer_File $phpcsFile
	 * @param int $stackPtr
	 * @return void|int
	 */
	public function process(\PHP_CodeSniffer_File $phpcsFile, $stackPtr)
	{
		$tokens = $phpcsFile->getTokens();
		if (!\in_array($tokens[$stackPtr - 2]['code'], [\T_ABSTRACT, \T_FINAL])
			&& !SuppressHelper::isSniffSuppressed(
				$phpcsFile,
				$stackPtr,
				\sprintf('LookymanCodingStandard.Classes.FinalClass.%s', self::CODE_NOT_FINAL_CLASS)
			)) {
			$fix = $phpcsFile->addFixableError(
				\sprintf(
					'Class %s is neither abstract nor final.',
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
